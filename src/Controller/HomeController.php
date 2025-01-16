<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route('/test-email', name: 'test_email')]
    public function testEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('example@example.com')
            ->to('recipient@example.com')
            ->subject('Test Email')
            ->text('Ceci est un test depuis Symfony');

        try {
            $mailer->send($email);
            return new Response('Email envoyé avec succès');
        } catch (\Exception $e) {
            return new Response('Erreur : ' . $e->getMessage());
        }
    }
}
