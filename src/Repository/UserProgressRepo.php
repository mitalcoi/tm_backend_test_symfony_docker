<?php

namespace App\Repository;

use App\Entity\QuestionWithAnswers;
use App\Entity\UserProgress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserProgressRepo extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private QuestionnaireRootRepo $questionnaireRootRepo)
    {
        parent::__construct($registry, UserProgress::class);
    }

    public function getMyProgressOrCreateNew(string $sessionRef, bool $flush = true): UserProgress
    {
        if ($progress = $this->findOneBy(['id' => $sessionRef])) {
            return $progress;
        } else {
            $root = $this->questionnaireRootRepo->getRoot();
            $progress = $root->addUserProgress($sessionRef);
            if ($flush) {
                $this->getEntityManager()->flush();
            }
        }

        return $progress;
    }

}