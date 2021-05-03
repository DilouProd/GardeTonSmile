<?php

namespace App\Controller;

use App\Entity\Publication;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PublicationsController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        $publications = $publicationRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('publications/index.html.twig', compact('publications'));
    }

    /**
     * @Route("/publication/create", name="app_publication_create", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER') and user.isVerified()")
     */
    public function create(Request $request, EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        $publication = new Publication;

        $form = $this->createForm(PublicationType::class, $publication);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $publication->setUser($this->getUser());
            $em->persist($publication);
            $em->flush();

            $this->addFlash('success', 'Votre Publication a était créer avec succées!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('publications/create.html.twig', [
            'form' => $form->createView()
    
    ]);

    }
    /**
     * @Route("/publication/{id<[0-9]+>}", name="app_publications_show", methods="GET")
     * 
     */

    public function show(Publication $publication): Response
    {
        return $this->render('publications/show.html.twig', compact('publication'));
    }

    /**
     * @Route("/publication/{id<[0-9]+>}/modifier", name="app_publication_edit", methods={"GET", "PUT"})
     * @Security("is_granted('PUBLICATION_MANAGE', publication)")
     */

    public function edit(Publication $publication,Request $request, EntityManagerInterface $em): Response
    {
        // if(! $this->getUser()){
        //     $this->addFlash('error', 'Tu dois d\'abord etre connecter !');
        //     return $this->redirectToRoute('app_login');
        // }
        // if(! $this->getUser()->isVerified()){
        //     $this->addFlash('error', 'Tu dois d\'abord valider ton adresse email !');
        //     return $this->redirectToRoute('app_home');
        // }
        // if($publication->getUser() != $this->getUser()){
        //     $this->addFlash('error', 'Accès interdit !');
        //     return $this->redirectToRoute('app_home');
        // }

        $form = $this->createForm(PublicationType::class, $publication, [
            'method' =>'PUT'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();

            $this->addFlash('success', 'Votre Publication a était modifier avec succées!');

            return $this->redirectToRoute('app_home');

        }
        return $this->render('publications/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/publication/{id<[0-9]+>}", name="app_publication_delete", methods={"DELETE"})
     *@Security("is_granted('PUBLICATION_MANAGE', publication)")     
     */

    public function delete(Request $request, Publication $publication, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('suppression_publication_' . $publication->getId(), $request->request->get('csrf_token'))) {
            $em->remove($publication);
            $em->flush();

            $this->addFlash('info', 'Votre Publication a était supprimer avec succées!');

        }
        return $this->redirectToRoute('app_home');
    }
}
