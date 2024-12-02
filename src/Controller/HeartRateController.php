<?php

namespace App\Controller;

use App\Entity\HeartRate;
use App\Form\HeartRateType;
use App\Repository\HeartRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/heart/rate')]
class HeartRateController extends AbstractController
{
    #[Route('/', name: 'app_heart_rate_index', methods: ['GET'])]
    public function index(HeartRateRepository $heartRateRepository): Response
    {
        
        return $this->render('heart_rate/index.html.twig', [
            'heart_rates' => $heartRateRepository->findAll(),
        ]);
    }

    public function showSensorDataForSensor(int $id, EntityManagerInterface $entityManager): Response
{
    // Trouver le capteur (Temperature ou HeartRate)
    $sensor = $entityManager->getRepository(HeartRate::class)->find($id);

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


    #[Route('/new', name: 'app_heart_rate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $heartRate = new HeartRate();
        $form = $this->createForm(HeartRateType::class, $heartRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($heartRate);
            $entityManager->flush();

            return $this->redirectToRoute('app_heart_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('heart_rate/new.html.twig', [
            'heart_rate' => $heartRate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_heart_rate_show', methods: ['GET'])]
    public function show(HeartRate $heartRate): Response
    {
        return $this->render('heart_rate/show.html.twig', [
            'heart_rate' => $heartRate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_heart_rate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HeartRate $heartRate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HeartRateType::class, $heartRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_heart_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('heart_rate/edit.html.twig', [
            'heart_rate' => $heartRate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_heart_rate_delete', methods: ['POST'])]
    public function delete(Request $request, HeartRate $heartRate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$heartRate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($heartRate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_heart_rate_index', [], Response::HTTP_SEE_OTHER);
    }
}
