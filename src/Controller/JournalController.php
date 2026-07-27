<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JournalController extends AbstractController
{
    #[Route('/journal', name: 'app_journal_index')]
    public function index(
        Request $request,
        ArticleRepository $articleRepository,
        CategorieRepository $categorieRepository,
        PaginatorInterface $paginator
    ): Response {
        $slugCategorie = $request->query->get('categorie');
        $categorie = $slugCategorie ? $categorieRepository->findBySlug($slugCategorie) : null;

        $articles = $articleRepository->findPublies($categorie?->getId());

        $pagination = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('journal/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $categorieRepository->findAllTriees(),
            'categorieActive' => $categorie,
        ]);
    }

    #[Route('/journal/{slug}', name: 'app_journal_show')]
    public function show(string $slug, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findOneBy(['slug' => $slug, 'statut' => 'publie']);

        if (!$article) {
            throw $this->createNotFoundException('Article introuvable.');
        }

        $suggestions = array_slice(array_filter(
            $articleRepository->findPublies($article->getCategorie()?->getId()),
            fn($a) => $a->getId() !== $article->getId()
        ), 0, 2);

        return $this->render('journal/show.html.twig', [
            'article' => $article,
            'suggestions' => $suggestions,
        ]);
    }
}