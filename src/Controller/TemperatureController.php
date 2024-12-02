<?php

namespace App\Controller;

use App\Entity\Temperature;
use App\Form\TemperatureType;
use App\Repository\TemperatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/temperature')]
class TemperatureController extends AbstractController
{
    #[Route('/', name: 'app_temperature_index', methods: ['GET'])]
    public function index(TemperatureRepository $temperatureRepository): Response
    {
        return $this->render('temperature/index.html.twig', [
            'temperatures' => $temperatureRepository->findAll(),
        ]);
    }

    

    public function showSensorDataForSensor(int $id, EntityManagerInterface $entityManager): Response
{
    // Trouver le capteur (Temperature ou HeartRate)
    $sensor = $entityManager->getRepository(Temperature::class)->find($id);

    if (!$sensor) {
        return new Response('Capteur non trouvé', 404);
    }

    // Récupérer toutes les données associées
    $sensorDatas = $sensor->getSensorDatas();

    return $this->render('sensor_data/index.html.twig', [
        'sensor' => $sensor,
        'sensor_datas' => $sensorDatas,
    ]);
}


    #[Route('/new', name: 'app_temperature_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $temperature = new Temperature();
        $form = $this->createForm(TemperatureType::class, $temperature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($temperature);
            $entityManager->flush();

            return $this->redirectToRoute('app_temperature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temperature/new.html.twig', [
            'temperature' => $temperature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_temperature_show', methods: ['GET'])]
    public function show(Temperature $temperature): Response
    {
        return $this->render('temperature/show.html.twig', [
            'temperature' => $temperature,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_temperature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Temperature $temperature, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TemperatureType::class, $temperature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_temperature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temperature/edit.html.twig', [
            'temperature' => $temperature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_temperature_delete', methods: ['POST'])]
    public function delete(Request $request, Temperature $temperature, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temperature->getId(), $request->request->get('_token'))) {
            $entityManager->remove($temperature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_temperature_index', [], Response::HTTP_SEE_OTHER);
    }
}
