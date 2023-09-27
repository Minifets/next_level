<?php

namespace App\Controller\Admin;

use App\Entity\Visit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VisitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Visit::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('ip'),
            BooleanField::new('clicked'),
        ];
    }

}
