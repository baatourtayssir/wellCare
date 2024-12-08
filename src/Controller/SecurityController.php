<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\HeartRateRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class SecurityController extends AbstractController
{


    // #[Route('/profile', name: 'app_base')]
    // public function base(HeartRateRepository $heartRateRepository, ChartBuilderInterface $chartBuilder): Response
    // {
    //     // Get the connected device of the logged-in user
    //     $connectedDevice = $this->getUser()->getConnectedDevices()->first();

    //     if (!$connectedDevice) {
    //         throw $this->createNotFoundException('No connected device found for this user.');
    //     }

    //     // Fetch heart rate data related to the connected device
    //     $heartRates = $heartRateRepository->findBy(['connectedDevice' => $connectedDevice]);

    //     // Initialize arrays to hold the data and timestamps
    //     $timestamps = [];
    //     $heartRateValues = [];

    //     // Loop through heart rate entities and fetch associated sensor data
    //     foreach ($heartRates as $heartRate) {
    //         foreach ($heartRate->getSensorDatas() as $sensorData) {
    //             $timestamps[] = $sensorData->getCapturedAt()->format('Y-m-d H:i:s'); // Assuming capturedAt is correctly defined in SensorData
    //             $heartRateValues[] = $sensorData->getData(); // Assuming heart rate value is stored in `data` in SensorData
    //         }
    //     }



    //     $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

    //     $chart->setData([
    //         'labels' => $timestamps ,
    //         'datasets' => [
    //             [
    //                 'label' => 'My First dataset',
    //                 'backgroundColor' => 'rgb(255, 99, 132)',
    //                 'borderColor' => 'rgb(255, 99, 132)',
    //                 'data' => $heartRateValues,
    //             ],
    //         ],
    //     ]);

    //     $chart->setOptions([
    //         'scales' => [
    //             'y' => [
    //                 'suggestedMin' => 0,
    //                 'suggestedMax' => 100,
    //             ],
    //         ],
    //     ]);

    //     // Pass data to Twig for rendering the chart
    //     return $this->render('base.html.twig', [
    //         'heartRates' => json_encode($heartRateValues), // Encodage JSON pour Twig
    //         'timestamps' => json_encode($timestamps),
    //         'chart' => $chart,
    //     ]);
    // }

    #[Route('/profile', name: 'app_base')]
    public function base(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_base');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
