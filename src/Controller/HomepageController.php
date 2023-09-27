<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        $feedback = $this->createForm(FeedbackType::class);

        return $this->render('homepage/index.html.twig', [
            'feedback' => $feedback->createView(),
        ]);
    }

    #[Route('/feedback', name: 'app_feedback', methods: ['POST'])]
    public function feedback(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedback = $this->createForm(FeedbackType::class);
        $feedback->handleRequest($request);

        if ($feedback->isSubmitted() && $feedback->isValid()) {
            $data = $feedback->getData();

            $entityManager->persist($data);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_thanks');
    }

    #[Route('/thanks', name: 'app_thanks')]
    public function thanks(): Response
    {
        return $this->render('homepage/thanks.html.twig');
    }
}
