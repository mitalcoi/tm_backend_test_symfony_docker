<?php

namespace App\Controller;

use App\Dto\UserAnswerDto;
use App\Entity\QuestionWithAnswers;
use App\Entity\UserProgress;
use App\Repository\QuestionnaireRootRepo;
use App\Repository\UserProgressRepo;
use App\Service\QuestionnaireAnswerEngine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function __construct(
        private UserProgressRepo $progressRepo,
        private QuestionnaireAnswerEngine $questionnaireAnswerEngine,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route("/", name: 'app_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $myProgress = $this->getMyProgress($request);

        return $this->render('questions.html.twig', ['myProgress' => $myProgress]);
    }

    #[Route("/reset_progress", name: 'app_reset_progress', methods: ['POST'])]
    public function resetProgress(Request $request): Response
    {
        $request->getSession()->remove('myProgressId');

        return $this->redirectToRoute('app_index');
    }

    private const MY_PROGRESS_TOKEN = 'myProgressId';

    #[Route("/answer/{question}", name: 'app_answer', methods: ['POST'])]
    public function answer(QuestionWithAnswers $question, Request $request): Response
    {
        $myProgress = $this->getMyProgress($request);
        $inputBody = $request->request->all();
        assert(!empty($inputBody['answers']));
        $answers = $inputBody['answers'];
        $myProgress->answer(new UserAnswerDto(
            question: $question,
            answers: $answers
        ), $this->questionnaireAnswerEngine);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_index');
    }

    private function getMyProgress(Request $request): UserProgress
    {
        if (!$request->getSession()->get(self::MY_PROGRESS_TOKEN)) {
            $request->getSession()->set(self::MY_PROGRESS_TOKEN, uuid_create());
        }

        return $this->progressRepo->getMyProgressOrCreateNew($request->getSession()->get(self::MY_PROGRESS_TOKEN));
    }
}