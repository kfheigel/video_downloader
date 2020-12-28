<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Form\ContactFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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
        if(!$this->getUser()==null && $this->getUser()->isVerified()==0){
            return $this->redirectToRoute('index'); 
        }
        
        $logger->info('ContactController started working');

        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new TemplatedEmail())
                ->from($data['email'])
                ->to($serviceOwnerEmail)
                ->subject('Heivice - ' . $data['subject'])
                ->htmlTemplate('mail/contactMail.html.twig')
                ->context([
                    'sender_email' => $data['email'],
                    'subject' => $data['subject'],
                    'text' => $data['text']
                ]);

            try {
                $mailer->send($email);
                $this->addFlash(
                    'success',
                    "Your email is on it's way to me!"
                );
            } catch (TransportExceptionInterface $e) {
                $this->addFlash(
                    'danger',
                    'Ooops! Something went wrong! Try again (a little bit) later!'
                );
                return $this->render('error/errorMail.html.twig');
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
