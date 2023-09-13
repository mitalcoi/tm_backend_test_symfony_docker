<?php

namespace App\Repository;

use App\Entity\QuestionnaireRoot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionnaireRootRepo extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionnaireRoot::class);
    }


    public function getRoot(): QuestionnaireRoot
    {
        return $this->findOneBy(['id'=>QuestionnaireRoot::ROOT_ID]);
    }

}