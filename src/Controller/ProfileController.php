<?php

namespace App\Controller;

use App\Entity\Milestone\Milestone;
use App\Entity\Progress\Progress;
use App\Entity\User\Student;
use App\Repository\Milestone\MilestoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /** @var Student $user */
        $user     = $this->getUser();
        $progress = $user->getProgress();
        $rewards  = $user->getRewards();

        if (null === $progress) {
            $rootMilestone = $entityManager->getRepository(Milestone::class)->findOneBy(['previous' => null]);
            $rootStage = $rootMilestone->getStages()->first();

            $progress = new Progress();
            $progress->setStugent($user);
            $progress->setStage($rootStage);

            $entityManager->persist($progress);
            $entityManager->flush();
        }

        return $this->render('profile/index.html.twig', [
            'user'     => $user,
            'progress' => $progress,
            'rewards'  => $rewards,
        ]);
    }
}
