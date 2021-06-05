<?php

namespace App\Controller;

use App\Entity\UserHistory;
use App\Form\VideoDownloadType;
use App\Service\Downloader;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloaderController extends AbstractController
{
    /**
     * @Route("/downloader", name="downloader")
     */
    public function index(Request $request, LoggerInterface $logger, Downloader $youtubeDownload): Response
    {   
        
        $logger->info('IndexController started working');
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(VideoDownloadType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $videoLink = $data['input'];
            $logger->info('Form is submitted');
            $links = $youtubeDownload->downloadVideo($videoLink);
            
            $videoId = $youtubeDownload->videoId($videoLink);
            $videoTitle = $youtubeDownload->videoTitle($videoLink);

            if(null !== $this->getUser()){
                if (0 == $this->getUser()->isVerified()) {
                    return $this->redirectToRoute('index');
                }else{
                    $userHistory = new UserHistory();
                    $userHistory->setUserId($this->getUser());
                    $userHistory->setYoutubeLinks($videoLink);
                    $userHistory->setVideoId($videoId);
                    $userHistory->setVideoTitle($videoTitle);
                    $em->persist($userHistory);
                    $em->flush();
                }
            }
            
        } else {
            $links = '';
            $videoId = '';
            $videoLink = '';
            $videoTitle = '';
        }

        if ($this->getUser()) {
            $history = $this->getDoctrine()->getRepository(UserHistory::class)->findUserDownloadHistory($this->getUser()->getId());
        } else {
            $history = [];
        }

        return $this->render('downloader/index.html.twig', [
            'form' => $form->createView(),
            'links' => $links,
            'videoId' => $videoId,
            'videoLink' => $videoLink,
            'videoTitle' => $videoTitle,
            'history' => $history,
        ]);
    }
}
