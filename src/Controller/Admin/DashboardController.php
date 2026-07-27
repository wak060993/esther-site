<?php

namespace App\Controller\Admin;

use App\Entity\Abonne;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
{
    $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

    return $this->redirect($adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());
}

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Esther — Espace admin')
            ->setLocales(['fr']);
    }

    public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
    yield MenuItem::section('Contenu');
    yield MenuItem::linkTo(ArticleCrudController::class, 'Articles', 'fa fa-newspaper');
    yield MenuItem::linkTo(CategorieCrudController::class, 'Catégories', 'fa fa-tags');
    yield MenuItem::section('Boutique');
    yield MenuItem::linkTo(LivreCrudController::class, 'Livres', 'fa fa-book');
    yield MenuItem::section('Communauté');
    yield MenuItem::linkTo(AbonneCrudController::class, 'Abonnés newsletter', 'fa fa-envelope');
    yield MenuItem::section();
    yield MenuItem::linkToUrl('Voir le site', 'fa fa-external-link-alt', '/');
}
}