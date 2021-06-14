<?php

namespace App\Controller;

use App\Entity\Memos;
use App\Form\MemosType;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemosController extends AbstractController
{
    /**
     * @Route("/memos", name="memos")
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        if ($this->getUser()===null) {
            return $this->redirectToRoute('index');
        }
        
        $logger->info('MemosController started working');
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(MemosType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $logger->info('Memo is submitted.');

            if(null !== $this->getUser()){
                if (0 == $this->getUser()->isVerified()) {
                    return $this->redirectToRoute('index');
                }else{
                    $memo = new Memos();
                    $memo->setUserId($this->getUser());
                    $memo->setMemo($data['memo']);
                    $memo->setTitle($data['title']);
                    $memo->setCreatedAt(new \DateTime("now"));
                    $memo->setTrash(false);

                    $em->persist($memo);
                    $em->flush();
                }
            }
        }
        if ($this->getUser()) {
            $history = $this->getDoctrine()->getRepository(Memos::class)->findUserMemos($this->getUser()->getId());
        } else {
            $history = [];
        }

        return $this->render('memos/index.html.twig', [
            'form' => $form->createView(),
            'history' => $history,
        ]);
    }

    /**
     * @Route("/memos/delete/{id?0}", name="memos_delete")
     * requirements={"id"="\d+"})
     */
    public function deleteMemo(int $id, LoggerInterface $logger): Response
    {
        $user_id = $this->getUser()->getId();
        $this->getDoctrine()->getRepository(Memos::class)->deleteUserMemos($user_id, $id);

        $logger->info('Memo has been deleted ' . $id);
        return $this->redirectToRoute('memos');
    }

    /**
     * @Route("/memos/edit/{id?0}", name="memos_edit")
     * requirements={"id"="\d+"})
     */
    public function editMemo(int $id, Request $request, LoggerInterface $logger): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MemosType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $logger->info('Memo is edited.');

            $memo = $em->getRepository(Memos::class)->find($id);
            if (!$memo) {
                throw $this->createNotFoundException(
                    'No memo found for id '.$id
                );
            }
            $memo->setMemo($data['memo']);
            $memo->setTitle($data['title']);
            $memo->setCreatedAt(new \DateTime("now"));
            $em->flush();
            return $this->redirectToRoute('memos');
        }

        $memo = $this->getDoctrine()->getRepository(Memos::class)->findMemo($id)[0];
        if (!$memo) {
            throw $this->createNotFoundException(
                'No memo found for id '.$id
            );
        }
        $form->get('title')->setData($memo->getTitle());
        $form->get('memo')->setData($memo->getMemo());
        
        return $this->render('memos/edit.html.twig', [
            'form' => $form->createView(),
            'memo' => $memo,
        ]);
    }
}
