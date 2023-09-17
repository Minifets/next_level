<?php

namespace App\Controller\Admin;

use App\Entity\Progress\Achievement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class AchievementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Achievement::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('milestone'),
            ImageField::new('image')->setUploadDir('public/uploads/achievements')->setBasePath('/uploads/achievements')->setRequired(true),
            ImageField::new('fallbackImage')->setUploadDir('public/uploads/achievements')->setBasePath('/uploads/achievements')->setRequired(true),
        ];
    }

}
