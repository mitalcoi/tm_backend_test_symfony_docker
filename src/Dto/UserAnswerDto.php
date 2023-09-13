<?php
namespace App\Dto;

use App\Entity\QuestionWithAnswers;

class UserAnswerDto
{
    public function __construct(
        public QuestionWithAnswers $question,
        /**
         * @var string[]
         */
        public array $answers,
    )
    {
    }
}