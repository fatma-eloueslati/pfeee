<?php

namespace App\Controller\Admin;

use App\Entity\Cagnotte;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\field\dateField;
use EasyCorp\Bundle\EasyAdminBundle\field\AssociationField;




class CagnotteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cagnotte::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('Titre'),
            TextEditorField::new('Description'),
            ImageField::new('urlphoto'),
            TextField::new('Beneficaire'),
            MoneyField::new('Objectif'),
            DateField::new('Deadline'),


        ];
    }
}
