<?php

namespace App\Repository;

use App\Entity\QuestionWithAnswers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionRepo extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionWithAnswers::class);
    }

    /**
     * @return QuestionWithAnswers[]
     */
    public function getAllQuestions():array{
        return $this->findAll();
    }

}