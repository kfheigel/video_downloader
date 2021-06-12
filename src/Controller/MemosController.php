<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemosController extends AbstractController
{
    /**
     * @Route("/memos", name="memos")
     */
    public function index(): Response
    {
        return $this->render('memos/index.html.twig', [
            'controller_name' => 'MemosController',
        ]);
    }
}
