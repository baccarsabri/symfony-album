<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AlbumSearchType;

/**
 * @Route("/album")
 */
class AlbumController extends AbstractController
{



 
    /**
     * @Route("/", name="app_album_index")
     */
    public function search(Request $request): Response
    {
        $form = $this->createForm(AlbumSearchType::class);
        $form->handleRequest($request);

        $allAlbums = $this->getDoctrine()->getRepository(Album::class)->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->get('search')->getData();
            $repository = $this->getDoctrine()->getRepository(Album::class);
            $allAlbums = $repository->findByTitleOrArtist($searchTerm);
        }

    

        return $this->render('album/index.html.twig', [
            'form' => $form->createView(),
            'albums' => $allAlbums,
        ]);
    }

    /**
     * @Route("/new", name="app_album_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AlbumRepository $albumRepository): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $albumRepository->add($album);
            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_album_show", methods={"GET"})
     */
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_album_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Album $album, AlbumRepository $albumRepository): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $albumRepository->add($album);
            return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_album_delete", methods={"POST"})
     */
    public function delete(Request $request, Album $album, AlbumRepository $albumRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $albumRepository->remove($album);
        }

        return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    }
}
