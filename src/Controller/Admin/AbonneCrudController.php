<?php

namespace App\Controller\Admin;

use App\Entity\Abonne;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class AbonneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Abonne::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['dateInscription' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW); // les abonnés s'ajoutent via le formulaire public, pas depuis l'admin
    }

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');
        yield DateTimeField::new('dateInscription')->onlyOnIndex();
        yield ChoiceField::new('statut')->setChoices(['Actif' => 'actif', 'Désinscrit' => 'desinscrit']);
    }
}