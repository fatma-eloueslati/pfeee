<?php

namespace App\Controller\Admin;

use App\Entity\DonPhy;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DonPhyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DonPhy::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
