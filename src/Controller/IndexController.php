<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Form\VideoDownloadType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(LoggerInterface $logger): Response
    {
        $logger->info('IndexController started working');

        $form = $this->createForm(VideoDownloadType::class);

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
