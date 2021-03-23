<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $publication = new Publication;

        $form = $this->createFormBuilder($publication)
        ->add('title',TextType::class)
        ->add('Description', TextareaType::class)
        ->getForm()

        ;
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($publication);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('publications/create.html.twig', [
            'form' => $form->createView()
    
    ]);

    }
    /**
     * @Route("/publication/{id<[0-9]+>}", name="app_publications_show", methods="GET")
     */

    public function show(Publication $publication): Response
    {
        return $this->render('publications/show.html.twig', compact('publication'));
    }

    /**
     * @Route("/publication/{id<[0-9]+>}/modifier", name="app_publication_edit", methods={"GET", "POST"})
     */

    public function edit(Publication $publication,Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder($publication)
        ->add('title',TextType::class)
        ->add('Description', TextareaType::class)
        ->getForm()

        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();

            return $this->redirectToRoute('app_home');

        }
        return $this->render('publications/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView()
        ]);
    }
}
