<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class QuestionWithAnswers
{
    public function __construct(
        #[Id, Column(type: 'guid')]
        public string $id,
        public string $question,
        public array $questions,
    )
    {
    }
}