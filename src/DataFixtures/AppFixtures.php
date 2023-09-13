<?php

namespace App\DataFixtures;

use App\Entity\QuestionnaireRoot;
use App\Entity\QuestionWithAnswers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $samples = json_decode(file_get_contents(__DIR__.'/test_samples.json'));
        $root =new QuestionnaireRoot();

        foreach ($samples as $question => $answerOptions) {
            $root->addQuestion(uuid_create(), $question, $answerOptions);
        }
        $manager->persist($root);
        $manager->flush();
    }
}
