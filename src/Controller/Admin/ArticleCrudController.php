<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->setDefaultSort(['dateCreation' => 'DESC'])
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre');

        yield TextField::new('slug')
            ->setHelp('Laisser vide : généré automatiquement depuis le titre')
            ->hideOnIndex()
            ->setRequired(false);

        yield AssociationField::new('categorie')
            ->setRequired(false);

        yield ChoiceField::new('statut')->setChoices([
            'Brouillon' => 'brouillon',
            'Publié' => 'publie',
        ]);

        yield DateTimeField::new('datePublication')
            ->setHelp('Laisser vide si brouillon');

        yield Field::new('imageFile')
            ->setFormType(VichImageType::class)
            ->setLabel('Image de couverture')
            ->onlyOnForms();

        yield ImageField::new('imageCouverture')
            ->setLabel('Image de couverture')
            ->setBasePath('uploads/articles')
            ->setUploadDir('public/uploads/articles')
            ->onlyOnIndex();

        yield TextareaField::new('extrait')
            ->setHelp('Résumé affiché sur les cartes (2-3 phrases)')
            ->hideOnIndex();

        yield TextEditorField::new('contenu')
            ->hideOnIndex();
    }
}