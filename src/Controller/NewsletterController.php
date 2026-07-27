<?php

namespace App\Controller;

use App\Entity\Abonne;
use App\Repository\AbonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/inscription', name: 'app_newsletter_inscription', methods: ['POST'])]
    public function inscrire(
        Request $request,
        AbonneRepository $abonneRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        $email = trim((string) $request->request->get('email'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['success' => false, 'message' => 'Email invalide.'], 400);
        }

        if ($abonneRepository->existeDeja($email)) {
            return new JsonResponse(['success' => true, 'message' => 'Déjà inscrit(e) !']);
        }

        $abonne = new Abonne();
        $abonne->setEmail($email);
        $abonne->setDateInscription(new \DateTimeImmutable());
        $abonne->setStatut('actif');

        $em->persist($abonne);
        $em->flush();

        return new JsonResponse(['success' => true, 'message' => 'Merci, c\'est fait !']);
    }
}