<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Form\UrlShortenerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UrlShortenerController extends AbstractController
{
    /**
     * @Route("shortener", name="shortener")
     */
    public function index(LoggerInterface $logger): Response
    {
        $logger->info('IndexController started working');
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UrlShortenerType::class);
        return $this->render('url_shortener/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
