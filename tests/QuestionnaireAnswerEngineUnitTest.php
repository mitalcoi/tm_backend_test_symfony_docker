<?php

namespace App\Tests;

use App\Service\QuestionnaireAnswerEngine;
use PHPUnit\Framework\TestCase;

class QuestionnaireAnswerEngineUnitTest extends TestCase
{

    public function testHandleMathAnswer()
    {
        $engine = new QuestionnaireAnswerEngine();
        $this->assertTrue($engine->handleMathAnswer(['5'], '2+3'));
        $this->assertTrue($engine->handleMathAnswer(['5', '3+2'], '2+3'));
        $this->assertFalse($engine->handleMathAnswer(['5', '3+2', '0'], '2+3'));
    }
}
