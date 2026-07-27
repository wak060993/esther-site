<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/a-propos', name: 'app_page_apropos')]
    public function apropos(): Response
    {
        return $this->render('page/apropos.html.twig');
    }
}