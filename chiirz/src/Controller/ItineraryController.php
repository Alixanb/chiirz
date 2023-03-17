<?php

namespace App\Controller;

use App\Entity\Itinerary;
use App\Entity\City;
use App\Form\ItineraryType;
use App\Repository\ItineraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/itinerary')]
class ItineraryController extends AbstractController
{
    #[Route('/', name: 'app_itinerary_index', methods: ['GET'])]
    public function index(ItineraryRepository $itineraryRepository): Response
    {
        return $this->render('itinerary/index.html.twig', [
            'itineraries' => $itineraryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_itinerary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ItineraryRepository $itineraryRepository): Response
    {
        $itinerary = new Itinerary();
        $form = $this->createForm(ItineraryType::class, $itinerary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itineraryRepository->save($itinerary, true);

            return $this->redirectToRoute('app_itinerary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('itinerary/new.html.twig', [
            'itinerary' => $itinerary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_itinerary_show', methods: ['GET'])]
    public function show(Itinerary $itinerary): Response
    {
        return $this->render('itinerary/show.html.twig', [
            'itinerary' => $itinerary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_itinerary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Itinerary $itinerary, ItineraryRepository $itineraryRepository): Response
    {
        $form = $this->createForm(ItineraryType::class, $itinerary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itineraryRepository->save($itinerary, true);

            return $this->redirectToRoute('app_itinerary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('itinerary/edit.html.twig', [
            'itinerary' => $itinerary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_itinerary_delete', methods: ['POST'])]
    public function delete(Request $request, Itinerary $itinerary, ItineraryRepository $itineraryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itinerary->getId(), $request->request->get('_token'))) {
            $itineraryRepository->remove($itinerary, true);
        }

        return $this->redirectToRoute('app_itinerary_index', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/{id}/show', name: 'app_itinerary_showbyid', methods: ['POST'])]
    // public function showByCity(Request $request, Itinerary $itinerary, ItineraryRepository $itineraryRepository): Response
    // {
    //     return $this->render('itinerary/show.html.twig', [
    //         'itinerary' => $itinerary,
    //     ]);
    // }

    // #[Route('/showbycity/{id}', name: 'app_itinerary_showbyid', methods: ['GET'])]
    // public function showByCity(Itinerary $itinerary, EntityManagerInterface $entityManager): Response
    // {
    //     $id = $itinerary->getId();
        
    //     $itineraryRepository = $entityManager->getRepository(Itinerary::class);
    //     dump($itinerary->getFkCity()->getId());
    //     // Recupere les itineraires de la ville
    //     $itineraries = $itineraryRepository->createQueryBuilder('i')
    //         ->where('i.fk_city  = :id')
    //         ->setParameter('id', $id)
    //         ->getQuery()
    //         ->getResult();

    //     return $this->render('itinerary/index.html.twig', [
    //         'itineraries' => $itineraries,
    //     ]);
    // }
}
