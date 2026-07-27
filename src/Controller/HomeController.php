<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, LivreRepository $livreRepository): Response
    {
        $derniersArticles = array_slice($articleRepository->findPublies(), 0, 3);
        $livres = array_slice($livreRepository->findAllOrdonnes(), 0, 4);

        return $this->render('home/index.html.twig', [
            'articles' => $derniersArticles,
            'livres' => $livres,
        ]);
    }
}