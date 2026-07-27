<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom');
        yield TextField::new('slug')->setHelp('ex: resilience, habitudes...');
        yield TextField::new('couleurAccent')->setHelp('Code couleur hexadécimal, ex: #C9982E')->hideOnIndex();
    }
}