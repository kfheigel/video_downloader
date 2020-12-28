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
        if(!$this->getUser()==null && $this->getUser()->isVerified()==0){
            return $this->redirectToRoute('index'); 
        }else{
            return $this->render('about/index.html.twig', [
                ]);
        }
        
    }
}
