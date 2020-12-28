<?php

namespace App\Controller;

use App\Entity\UserHistory;
use App\Service\Downloader;
use Psr\Log\LoggerInterface;
use App\Form\VideoDownloadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DownloaderController extends AbstractController
{
    /**
     * @param Request $request
     * @param LoggerInterface $logger
     * @param Downloader $youtubeDownload
     * @return Response
     * @Route("/downloader", name="downloader")
     */
    public function index(Request $request, LoggerInterface $logger, Downloader $youtubeDownload): Response
    {
        if(!$this->getUser()==null && $this->getUser()->isVerified()==0){
            return $this->redirectToRoute('index');
        }

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

            $userHistory = new UserHistory();
            $userHistory->setUserId($this->getUser());
            $userHistory->setYoutubeLinks($videoLink);
            $userHistory->setVideoId($videoId);
            $userHistory->setVideoTitle($videoTitle);
            $em->persist($userHistory);
            $em->flush();
        } else {
            $links = '';
            $videoId = '';
            $videoLink = '';
            $videoTitle = '';
        }

        if($this->getUser()){
            $history = $this->getDoctrine()->getRepository(UserHistory::class)->findUserDownloadHistory($this->getUser()->getId());
        }else{
            $history=[];
        }
        
                return $this->render('downloader/index.html.twig', [
            'form' => $form->createView(),
            'links' => $links,
            'videoId' => $videoId,
            'videoLink' => $videoLink,
            'videoTitle' => $videoTitle,
            'history' => $history
        ]);
    }
}
