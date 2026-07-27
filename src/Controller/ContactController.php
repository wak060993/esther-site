<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $envoye = false;
        $erreur = null;

        if ($request->isMethod('POST')) {
            $nom = trim((string) $request->request->get('nom'));
            $email = trim((string) $request->request->get('email'));
            $message = trim((string) $request->request->get('message'));

            if (empty($nom) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
                $erreur = 'Merci de remplir tous les champs correctement.';
            } else {
                $mail = (new Email())
                    ->from($email)
                    ->to('esther@example.com') // à remplacer par le vrai email d'Esther
                    ->subject('Nouveau message depuis le site — ' . $nom)
                    ->text("De : $nom ($email)\n\n$message");

                try {
                    $mailer->send($mail);
                    $envoye = true;
                } catch (\Exception $e) {
                    $erreur = "L'envoi a échoué, réessaie plus tard.";
                }
            }
        }

        return $this->render('contact/index.html.twig', [
            'envoye' => $envoye,
            'erreur' => $erreur,
        ]);
    }
}