<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Form\FeedbackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedback = $this->createForm(FeedbackType::class);

        $session = $request->getSession();
        $flashBag = $session->getFlashBag();
        $visitId = $flashBag->peek('visit');

        if (empty($visitId)) {
            $visit = new Visit();
            $visit->setIp($_SERVER['REMOTE_ADDR']);
            $entityManager->persist($visit);
            $entityManager->flush();

            $flashBag->add('visit', $visit->getId());
        }

        return $this->render('homepage/index.html.twig', [
            'feedback' => $feedback->createView(),
        ]);
    }

    #[Route('/click', name: 'app_click')]
    public function click(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $visitId = $session->getFlashBag()->peek('visit');

        $visit = $entityManager->getRepository(Visit::class)->findOneBy(['id' => $visitId[0] ?? null]);

        if (null !== $visit) {
            $visit->setClicked(true);
            $entityManager->flush();
        }

        return $this->json(200);
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
