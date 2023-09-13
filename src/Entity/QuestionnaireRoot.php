<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class QuestionnaireRoot
{
    #[OneToMany(mappedBy: 'root', targetEntity: QuestionWithAnswers::class, cascade: ['persist'])]
    private Collection $questions;

    #[OneToMany(mappedBy: 'root', targetEntity: UserProgress::class, cascade: ['persist'])]
    private Collection $progresses;
    #[Id, Column(type: 'string')]
    private string $id;
    public const ROOT_ID = '_';

    public function __construct()
    {
        $this->id = self::ROOT_ID;
        $this->questions = new ArrayCollection();
        $this->progresses = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function addUserProgress(string $id): UserProgress
    {
        $progress = UserProgress::create($this, $id);
        $this->progresses->add($progress);

        return $progress;
    }

    public function addQuestion(string $id, string $question, array $answerOptions): void
    {
        $questionWithAnswers = QuestionWithAnswers::loadData($this, $id, $question, $answerOptions);
        $this->questions->add($questionWithAnswers);
    }

    /**
     * @return QuestionWithAnswers[]
     */
    public function getQuestions(): array
    {
        return $this->questions->toArray();
    }


}