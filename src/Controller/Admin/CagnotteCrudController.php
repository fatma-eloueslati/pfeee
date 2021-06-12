<?php

namespace App\Controller\Admin;

use App\Entity\Cagnotte;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;




class CagnotteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cagnotte::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('Titre'),
            TextEditorField::new('Description'),
            TextField::new('Beneficaire'),
            IntegerField::new('Objectif'),
            DateField::new('Deadline'),
            TextField::new('Urlphoto'),
            TextField::new('Category'),

        ];
    }
}
