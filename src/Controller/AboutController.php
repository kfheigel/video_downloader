<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function index(): Response
    {
        if (null == !$this->getUser() && 0 == $this->getUser()->isVerified()) {
            return $this->redirectToRoute('index');
        } else {
            return $this->render('about/index.html.twig', [
                ]);
        }
    }
}
