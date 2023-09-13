<?php

namespace App\Entity;

use App\Dto\UserAnswerDto;
use App\Service\QuestionnaireAnswerEngine;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class UserProgress
{
    #[Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $finishedAt;


    #[OneToMany(mappedBy: 'progress', targetEntity: UserProgressTrack::class, cascade: ['persist'])]
    private Collection $progressTracks;


    private function __construct(
        #[Id, Column(type: 'guid')]
        private string $id,
        #[ManyToOne(targetEntity: QuestionnaireRoot::class, inversedBy: 'progresses')]
        private QuestionnaireRoot $root,
    ) {
        $this->progressTracks = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function create(QuestionnaireRoot $root, string $sessionId): UserProgress
    {
        return new UserProgress($sessionId, $root);
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
     * @return UserProgressTrack[]
     */
    public function getProgressTracks(): array
    {
        return $this->progressTracks->getValues();
    }


    public function answer(UserAnswerDto $answerDto, QuestionnaireAnswerEngine $answerEngine): UserProgressTrack
    {
        if ($this->isFinished()) {
            throw new \DomainException("Test is actually passed");
        }
        $track = UserProgressTrack::create($this, $answerDto->question, $answerDto->answers,
            $answerEngine->handleMathAnswer($answerDto->answers, $answerDto->question->getQuestion()));
        $this->progressTracks->add($track);
        if ($this->isFinished()) {
            $this->finishedAt = new \DateTimeImmutable();
        }

        return $track;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function leftToFinish(): int
    {
        $total = count($this->root->getQuestions());
        foreach ($this->root->getQuestions() as $question) {
            if ($this->isQuestionPassed($question)) {
                $total--;
            }
        }

        return $total;
    }

    public function upcomingQuestion($randomize = true): ?QuestionWithAnswers
    {
        $questions = $this->root->getQuestions();
        if($randomize){
            array_rand($questions);
        }
        foreach ($questions as $question) {
            if (!$this->isQuestionPassed($question)) {
                return $question;
            }
        }

        return null;
    }

    private function isQuestionPassed(QuestionWithAnswers $question): bool
    {
        foreach ($this->getProgressTracks() as $progressTrack) {
            if ($progressTrack->getQuestion()->getId() === $question->getId()) {
                return true;
            }
        }

        return false;
    }

    public function isFinished(): bool
    {
        return $this->upcomingQuestion() === null;
    }
}