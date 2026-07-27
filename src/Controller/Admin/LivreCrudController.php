<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['ordreAffichage' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre');
        yield TextField::new('slug')->setHelp('Généré automatiquement')->setRequired(false)->hideOnIndex();

        yield Field::new('couvertureFile')
            ->setFormType(VichImageType::class)
            ->setLabel('Couverture')
            ->onlyOnForms();

        yield ImageField::new('couverture')
            ->setLabel('Couverture')
            ->setBasePath('uploads/livres')
            ->setUploadDir('public/uploads/livres')
            ->onlyOnIndex();

        yield TextareaField::new('description')->hideOnIndex();
        yield UrlField::new('lienExterne')->setLabel('Lien Amazon / boutique');
        yield IntegerField::new('ordreAffichage')->setHelp('0 = affiché en premier');
    }
}