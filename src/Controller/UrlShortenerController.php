<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Form\UrlShortenerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UrlShortenerController extends AbstractController
{
    /**
     * @Route("shortener", name="shortener")
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $logger->info('IndexController started working');
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UrlShortenerType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $longLink = $data['url'];
            $logger->info('Form is submitted. Link to shorten: ' . $longLink);
        }
        
        return $this->render('url_shortener/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
