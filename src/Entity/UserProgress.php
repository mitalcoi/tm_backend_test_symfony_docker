<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class UserProgress
{
    private function __construct(
        #[Id, Column(type: 'guid')]
        private string $id,
//        #[ManyToOne()]
//        private QuestionWithAnswers $question,
//        #[Column(type: 'string')]
//        private string $userAnswer,
//        #[Column(type: 'boolean')]
//        private bool $isCorrect,
    ) {
    }

    public static function create(string $sessionId): UserProgress
    {
        return new UserProgress($sessionId);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }



}