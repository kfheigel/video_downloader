<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Downloader;
use Psr\Log\LoggerInterface;
use App\Form\VideoDownloadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, LoggerInterface $logger, Downloader $youtubeDownload): Response
    {
        $logger->info('IndexController started working');

        $form = $this->createForm(VideoDownloadType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $videoLink = $data['input'];
            $logger->info('Form is submitted');
            $links = $youtubeDownload->downloadVideo($videoLink);
            $videoId = $youtubeDownload->videoId($videoLink);
        }else{
            $links = '';
            $videoId = '';
        }

        

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'links' => $links,
            'videoId' => $videoId,
        ]);
    }
}
