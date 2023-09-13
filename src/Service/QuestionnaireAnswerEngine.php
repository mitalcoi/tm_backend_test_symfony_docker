<?php

namespace App\Service;

use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class QuestionnaireAnswerEngine
{
    /**
     * Important note: current implementation will work only for simple alphanumeric tests
     * @param string[] $answers
     * @param string $question
     * @return bool
     */
    public function handleMathAnswer(array $answers, string $question): bool
    {
        $expressionLanguage = new ExpressionLanguage();
        assert(count($answers) >= 1);
        foreach ($answers as $answer) {
            if (!$expressionLanguage->evaluate(new Expression("$answer==$question"))) {
                return false;
            }
        }

        return true;
    }
}