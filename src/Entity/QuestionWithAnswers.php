<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class QuestionWithAnswers
{
    private function __construct(
        #[Id, Column(type: 'guid')]
        private string $id,
        #[Column(type: 'string')]
        private string $question,
        #[Column(type: 'json')]
        private array $answerOptions,
    ) {
    }

    public static function loadData(string $id, string $question, array $answerOptions): QuestionWithAnswers
    {
        return new QuestionWithAnswers($id, $question, $answerOptions);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return array
     */
    public function getAnswerOptions(): array
    {
        return $this->answerOptions;
    }


}