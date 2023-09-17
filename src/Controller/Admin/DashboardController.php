<?php

namespace App\Controller\Admin;

use App\Entity\Lesson\Exam;
use App\Entity\Lesson\Lesson;
use App\Entity\Milestone\Milestone;
use App\Entity\Milestone\Stage;
use App\Entity\Progress\Achievement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(MilestoneCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Next Level');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Milestones', 'fas fa-list', Milestone::class);
        yield MenuItem::linkToCrud('Stages', 'fas fa-list', Stage::class);
        yield MenuItem::linkToCrud('Achievement', 'fas fa-list', Achievement::class);
        yield MenuItem::linkToCrud('Lessons', 'fas fa-list', Lesson::class);
        yield MenuItem::linkToCrud('Exams', 'fas fa-list', Exam::class);
    }
}
