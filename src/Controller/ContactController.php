<?php

namespace App\Controller;
use App\Form\ContactFormType;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(MailerInterface $mailer, Request $request, LoggerInterface $logger, $serviceOwnerEmail): Response
    {
        if (null == !$this->getUser() && 0 == $this->getUser()->isVerified()) {
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
                ->subject('Heivice - '.$data['subject'])
                ->htmlTemplate('mail/contactMail.html.twig')
                ->context([
                    'sender_email' => $data['email'],
                    'subject' => $data['subject'],
                    'text' => $data['text'],
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
