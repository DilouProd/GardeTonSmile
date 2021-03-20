<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicationsController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        $publications = $publicationRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('publications/index.html.twig', compact('publications'));
    }

    /**
     * @Route("/publication/{id<[0-9]+>}", name="app_publucations_show")
     */

    public function show(Publication $publication): Response
    {
        return $this->render('publications/show.html.twig', compact('publication'));
    }
}
