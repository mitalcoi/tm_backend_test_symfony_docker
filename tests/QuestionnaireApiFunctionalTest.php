<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionnaireApiFunctionalTest extends WebTestCase
{
    use testTrait;

    private ?ReferenceRepository $referenceRepo = null;

    protected function setUp(): void
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->referenceRepo = $this->withFixtures(static::$kernel);
        parent::setUp();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Questions to finish test: 10', $response->getContent());
    }

    public function testAnswerTest()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('POST', '/answer/'.$this->referenceRepo->getReference('question_1')->getId(),
            ['answers' => ['5']],
        );
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Questions to finish test: 9', $response->getContent());
    }
}