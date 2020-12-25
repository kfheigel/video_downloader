<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        if (null == !$this->getUser() && 0 == $this->getUser()->isVerified()) {
            $this->addFlash(
                'danger',
                "Ooops! You have to verify your e-mail adress to access service content! Link is in the mail! Check Spam if you can't find it, or contact me through the contact form!"
            );
        }

        return $this->render('index/index.html.twig', [
        ]);
    }
}
