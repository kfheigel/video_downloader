<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyAccountController extends AbstractController
{
    /**
     * @Route("/my_account", name="my_account")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('index');
        // return $this->render('my_account/index.html.twig', [
        //     'controller_name' => 'MyAccountController',
        // ]);
    }
}
