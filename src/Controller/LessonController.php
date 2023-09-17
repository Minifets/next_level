<?php

namespace App\Controller;

use App\Entity\Milestone\Milestone;
use App\Entity\Milestone\Stage;
use App\Entity\Progress\Progress;
use App\Entity\Progress\Reward;
use App\Entity\User\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    #[Route('/lesson', name: 'app_lesson')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /** @var Student $student */
        $student = $this->getUser();
        $progress = $student->getProgress();

        if (null === $progress) {
            $rootMilestone = $entityManager->getRepository(Milestone::class)->findOneBy(['previous' => null]);
            $rootStage = $rootMilestone->getStages()->first();

            $progress = new Progress();
            $progress->setStugent($student);
            $progress->setStage($rootStage);

            $entityManager->persist($progress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lesson_stage', ['stage' => $progress->getStage()->getId()]);
    }

    #[Route('/lesson/stage/{stage}', name: 'app_lesson_stage')]
    public function stage(Stage $stage): Response
    {
        return $this->render('lesson/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    #[Route('/lesson/pass', name: 'app_lesson_stage_pass')]
    public function passExam(EntityManagerInterface $entityManager): Response
    {
        return $this->nextStage($entityManager);
    }

    #[Route('/lesson/next', name: 'app_lesson_stage_next')]
    public function nextStage(EntityManagerInterface $entityManager): Response
    {
        /** @var Student $student */
        $student = $this->getUser();
        $progress = $student->getProgress();
        $currentStage = $progress->getStage();

        $nextStage = $entityManager->getRepository(Stage::class)->findNextStage($currentStage);

        if (null === $nextStage) {
            $nextMilestone = $currentStage->getMilestone()->getNextMilestones()->first();

            if (!$nextMilestone instanceof Milestone) {
                return $this->redirectToRoute('app_profile');
            }

            $nextStage = $nextMilestone->getStages()->first();

            $reward = new Reward();
            $reward->setStudent($student);
            $reward->setAchievement($currentStage->getMilestone()->getAchievement());

            $entityManager->persist($reward);
        }

        $progress->setStage($nextStage);

        $entityManager->flush();

        return $this->redirectToRoute('app_lesson_stage', ['stage' => $progress->getStage()->getId()]);
    }
}
