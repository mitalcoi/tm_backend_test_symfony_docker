<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class UserProgressTrack
{

    #[Id, Column(type: 'integer'), GeneratedValue]
    private ?int $id;
    #[Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    private function __construct(
        #[ManyToOne(inversedBy: 'progressTracks')]
        private UserProgress $progress,
        #[ManyToOne()]
        private QuestionWithAnswers $question,
        #[Column(type: 'json')]
        private array $userAnswers,
        #[Column(type: 'boolean')]
        private bool $isCorrect,

    ) {
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function create(UserProgress $progress, QuestionWithAnswers $question, array $userAnswers, bool $isCorrect): UserProgressTrack
    {
        return new UserProgressTrack($progress, $question, $userAnswers, $isCorrect);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return QuestionWithAnswers
     */
    public function getQuestion(): QuestionWithAnswers
    {
        return $this->question;
    }

    /**
     * @return string[]
     */
    public function getUserAnswers(): array
    {
        return $this->userAnswers;
    }

    /**
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    /**
     * @return UserProgress
     */
    public function getProgress(): UserProgress
    {
        return $this->progress;
    }


}