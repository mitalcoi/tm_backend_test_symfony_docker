<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class QuestionWithAnswers
{
    private function __construct(
        #[Id, Column(type: 'guid')]
        private string $id,
        #[ManyToOne(targetEntity: QuestionnaireRoot::class, inversedBy: 'questions')]
        private QuestionnaireRoot $root,
        #[Column(type: 'string')]
        private string $question,
        #[Column(type: 'json')]
        private array $answerOptions,
    ) {
    }

    public static function loadData(QuestionnaireRoot $root, string $id, string $question, array $answerOptions): QuestionWithAnswers
    {
        return new QuestionWithAnswers($id, $root, $question, $answerOptions);
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

    /**
     * @return QuestionnaireRoot
     */
    public function getRoot(): QuestionnaireRoot
    {
        return $this->root;
    }


}