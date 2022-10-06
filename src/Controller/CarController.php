<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarFormType;
use App\Repository\CarRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/", name="app_car", methods={"GET"})
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $cars = $doctrine->getRepository(Car::class)->findAll();

        return $this->render('car/list.html.twig',[
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/new/car", name="app_car_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CarRepository $carRepository): Response
    {
        $car = new Car();

        $form = $this->createForm(CarFormType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->add($car, true);

            $this->addFlash('success', 'Voiture ajoutée');

            return $this->redirectToRoute('app_car', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/new.html.twig', [
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/edit/car/{id}", name="app_car_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Car $car, CarRepository $carRepository): Response
    {
        $form = $this->createForm(CarFormType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->add($car, true);

            $this->addFlash('success', 'Voiture modifiée');

            return $this->redirectToRoute('app_car', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/car/{id}", name="app_car_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car, true);
        }

        $this->addFlash('success', 'Voiture supprimée');

        return $this->redirectToRoute('app_car', [], Response::HTTP_SEE_OTHER);
    }
}
