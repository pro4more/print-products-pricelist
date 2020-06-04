<?php

namespace App\Controller;

use App\Entity\PricelistEntry;
use App\Form\PricelistEntryType;
use App\Repository\PricelistEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pricelist/entry")
 */
class PricelistEntryController extends AbstractController
{
    /**
     * @Route("/", name="pricelist_entry_index", methods={"GET"})
     */
    public function index(PricelistEntryRepository $pricelistEntryRepository): Response
    {
        return $this->render('pricelist_entry/index.html.twig', [
            'pricelist_entries' => $pricelistEntryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pricelist_entry_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pricelistEntry = new PricelistEntry();
        $form = $this->createForm(PricelistEntryType::class, $pricelistEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pricelistEntry);
            $entityManager->flush();

            return $this->redirectToRoute('pricelist_entry_index');
        }

        return $this->render('pricelist_entry/new.html.twig', [
            'pricelist_entry' => $pricelistEntry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricelist_entry_show", methods={"GET"})
     */
    public function show(PricelistEntry $pricelistEntry): Response
    {
        return $this->render('pricelist_entry/show.html.twig', [
            'pricelist_entry' => $pricelistEntry,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pricelist_entry_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PricelistEntry $pricelistEntry): Response
    {
        $form = $this->createForm(PricelistEntryType::class, $pricelistEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pricelist_entry_index');
        }

        return $this->render('pricelist_entry/edit.html.twig', [
            'pricelist_entry' => $pricelistEntry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricelist_entry_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PricelistEntry $pricelistEntry): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricelistEntry->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pricelistEntry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pricelist_entry_index');
    }
}
