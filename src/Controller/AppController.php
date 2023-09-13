<?php

namespace App\Controller;

use App\Repository\QuestionRepo;
use App\Repository\UserProgressRepo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function __construct(private QuestionRepo $questionRepo, private UserProgressRepo $progressRepo)
    {
    }

    #[Route("/", methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $questions = $this->questionRepo->getAllQuestions();
        if (!$request->getSession()->get('myProgressId')) {
            $request->getSession()->set('myProgressId', uuid_create());
        }
        $myProgress = $this->progressRepo->getMyProgressOrCreateNew($request->getSession()->get('myProgressId'));

        return $this->render('questions.html.twig', ['questions' => $questions, 'myProgress' => $myProgress]);
    }
    #[Route("/reset_progress")]
    public function cleanupProgress(Request $request): Response
    {
        $request->getSession()->remove('myProgressId');

        return $this->redirect('/');
    }
}