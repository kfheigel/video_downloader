<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @param MailerInterface $mailer
     * @param Request $request
     * @param LoggerInterface $logger
     * @return Response
     * @Route("/contact", name="contact")
     */
    public function index(MailerInterface $mailer, Request $request, LoggerInterface $logger, $serviceOwnerEmail): Response
    {
        $logger->info('ContactController started working');

        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from($data['email'])
                ->to($serviceOwnerEmail)
                ->subject('Heivice - formularz kontaktowy')
                ->text($data['email']. ' \n' . $data['text']);

            $mailer->send($email);
            dump($data['email']);
            dump($data['text']);
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
