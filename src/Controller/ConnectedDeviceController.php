<?php

namespace App\Controller;

use App\Entity\ConnectedDevice;
use App\Form\ConnectedDeviceType;
use App\Repository\ConnectedDeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


#[Route('/connected/device')]
class ConnectedDeviceController extends AbstractController
{
    #[Route('/', name: 'app_connected_device_index', methods: ['GET'])]
    public function index(ConnectedDeviceRepository $connectedDeviceRepository): Response
    {
        $user = $this->getUser();
    
        // Récupérer uniquement les connected devices associés à l'utilisateur connecté
        $connected_devices = $connectedDeviceRepository->findByUser($user);
    
        // Passer la bonne variable à la vue
        return $this->render('connected_device/index.html.twig', [
            'connected_devices' => $connected_devices, // Utiliser la variable filtrée
        ]);
    }
    
    #[Route('/new', name: 'app_connected_device_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security , ConnectedDeviceRepository $connectedDeviceRepository): Response
    {
        $connectedDevice = new ConnectedDevice();

            // Récupération de l'utilisateur connecté
    $user = $security->getUser();

    // Si un utilisateur est connecté, on assigne cet utilisateur à l'appareil
    if ($user) {
        $connectedDevice->setUser($user); // Assurez-vous que la méthode setUser() existe sur votre entité ConnectedDevice
    }

        $form = $this->createForm(ConnectedDeviceType::class, $connectedDevice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($connectedDevice);
            $entityManager->flush();

            return $this->redirectToRoute('app_connected_device_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('connected_device/new.html.twig', [
            'connected_devices' => $connectedDeviceRepository->findAll(),
            'connected_device' => $connectedDevice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_connected_device_show', methods: ['GET'])]
    public function show(ConnectedDevice $connectedDevice): Response
    {
        return $this->render('connected_device/show.html.twig', [
            'connected_device' => $connectedDevice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_connected_device_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConnectedDevice $connectedDevice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConnectedDeviceType::class, $connectedDevice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_connected_device_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('connected_device/edit.html.twig', [
            'connected_device' => $connectedDevice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_connected_device_delete', methods: ['POST'])]
    public function delete(Request $request, ConnectedDevice $connectedDevice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$connectedDevice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($connectedDevice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_connected_device_index', [], Response::HTTP_SEE_OTHER);
    }
}
