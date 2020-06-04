<?php

namespace App\Controller;

use App\Entity\AvailableFormat;
use App\Form\AvailableFormatType;
use App\Repository\AvailableFormatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/availableFormat")
 */
class AvailableFormatController extends AbstractController
{
    /**
     * @Route("/", name="available_format_index", methods={"GET"})
     */
    public function index(AvailableFormatRepository $availableFormatRepository): Response
    {
        return $this->render('available_format/index.html.twig', [
            'available_formats' => $availableFormatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="available_format_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $availableFormat = new AvailableFormat();
        $form = $this->createForm(AvailableFormatType::class, $availableFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($availableFormat);
            $entityManager->flush();

            return $this->redirectToRoute('available_format_index');
        }

        return $this->render('available_format/new.html.twig', [
            'available_format' => $availableFormat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="available_format_show", methods={"GET"})
     */
    public function show(AvailableFormat $availableFormat): Response
    {
        return $this->render('available_format/show.html.twig', [
            'available_format' => $availableFormat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="available_format_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AvailableFormat $availableFormat): Response
    {
        $form = $this->createForm(AvailableFormatType::class, $availableFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('available_format_index');
        }

        return $this->render('available_format/edit.html.twig', [
            'available_format' => $availableFormat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="available_format_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AvailableFormat $availableFormat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$availableFormat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($availableFormat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('available_format_index');
    }
}
