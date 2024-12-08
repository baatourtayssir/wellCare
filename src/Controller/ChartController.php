<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HeartRateRepository;
use App\Repository\HumidityRepository;
use App\Repository\TemperatureRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Controller\UXChartBuilderInterface;



class ChartController extends AbstractController
{

        private $chartBuilder;

    public function __construct(ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
    }
    #[Route('/heart-rate-chart', name: 'app_heart_rate_chart')]
    public function chart1(HeartRateRepository $heartRateRepository, ChartBuilderInterface $chartBuilder): Response
    {
        // Get the connected device of the logged-in user
        $connectedDevice = $this->getUser()->getConnectedDevices()->first();

        if (!$connectedDevice) {
            throw $this->createNotFoundException('No connected device found for this user.');
        }

        // Fetch heart rate data related to the connected device
        $heartRates = $heartRateRepository->findBy(['connectedDevice' => $connectedDevice]);

        // Initialize arrays to hold the data and timestamps
        $timestamps = [];
        $heartRateValues = [];

        // Loop through heart rate entities and fetch associated sensor data
        foreach ($heartRates as $heartRate) {
            foreach ($heartRate->getSensorDatas() as $sensorData) {
                $timestamps[] = $sensorData->getCapturedAt()->format('Y-m-d H:i:s'); // Assuming capturedAt is correctly defined in SensorData
                $heartRateValues[] = $sensorData->getData(); // Assuming heart rate value is stored in `data` in SensorData
            }
        }



        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $timestamps ,
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $heartRateValues,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        // Pass data to Twig for rendering the chart
        return $this->render('chart/chartHeartRate.html.twig', [
            'minHeartRate' => $heartRate->getMinHeartRate(),
            'maxHeartRate' => $heartRate->getMaxHeartRate(),
            'heartRates' => json_encode($heartRateValues), // Encodage JSON pour Twig
            'timestamps' => json_encode($timestamps),
            'chart' => $chart,
        ]);
    }




    #[Route('/temperature-chart', name: 'app_temperature_chart')]
    public function chart2(TemperatureRepository $temperatureRepository, ChartBuilderInterface $chartBuilder): Response
    {
        // Récupérer l'appareil connecté de l'utilisateur
        $connectedDevice = $this->getUser()->getConnectedDevices()->first();
    
        if (!$connectedDevice) {
            throw $this->createNotFoundException('No connected device found for this user.');
        }
    
        // Récupérer les données de température liées à l'appareil connecté
        $temperatures = $temperatureRepository->findBy(['connectedDevice' => $connectedDevice]);
    
        // Initialiser les tableaux pour stocker les données et les timestamps
        $timestamps = [];
        $temperatureValues = [];
    
        // Boucle pour récupérer les données de température et leurs timestamps
        foreach ($temperatures as $temperature) {
            foreach ($temperature->getSensorDatas() as $sensorData) {
                $timestamps[] = $sensorData->getCapturedAt()->format('Y-m-d H:i:s'); // Le timestamp
                $temperatureValues[] = $sensorData->getData(); // La température
            }
        }
    
        // Construire le graphique de température avec le builder
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
    
        $chart->setData([
            'labels' => $timestamps, // Les labels du graphique (timestamps)
            'datasets' => [
                [
                    'label' => 'Temperature (°C)', // Légende du graphique
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', // Couleur de fond
                    'borderColor' => 'rgba(54, 162, 235, 1)', // Couleur de la ligne
                    'data' => $temperatureValues, // Données de température
                    'fill' => false, // Pas de remplissage sous la ligne
                    'borderWidth' => 2, // Largeur de la ligne
                    'pointBackgroundColor' => 'rgba(54, 162, 235, 1)', // Couleur des points
                    'pointRadius' => 5, // Taille des points
                    'tension' => 0.4, // Lissage de la courbe
                ],
            ],
        ]);
    
        // Ajouter les limites min et max sur l'axe Y
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => $temperatures[0]->getMinTemperature(), // Valeur min
                    'suggestedMax' => $temperatures[0]->getMaxTemperature(), // Valeur max
                ],
            ],
        ]);
    
        // Passer les données à la vue Twig pour le rendu
        return $this->render('chart/chartTemerature.html.twig', [
            'minTemperature' => $temperatures[0]->getMinTemperature(), // Limite min
            'maxTemperature' => $temperatures[0]->getMaxTemperature(), // Limite max
            'temperatures' => json_encode($temperatureValues), // Données JSON encodées pour Twig
            'timestamps' => json_encode($timestamps), // Timestamps JSON encodés
            'chart' => $chart, // Le graphique construit
        ]);
    }
    

    #[Route('/humidity-chart', name: 'app_humidity_chart')]
    public function chart3(HumidityRepository $humidityRepository, ChartBuilderInterface $chartBuilder): Response
    {
        // Récupérer l'appareil connecté de l'utilisateur
        $connectedDevice = $this->getUser()->getConnectedDevices()->first();

        if (!$connectedDevice) {
            throw $this->createNotFoundException('No connected device found for this user.');
        }

        // Récupérer les données d'humidité liées à l'appareil connecté
        $humidities = $humidityRepository->findBy(['connectedDevice' => $connectedDevice]);

        // Initialiser les tableaux pour stocker les données et les timestamps
        $timestamps = [];
        $humidityValues = [];

        // Boucle pour récupérer les données d'humidité et leurs timestamps
        foreach ($humidities as $humidity) {
            foreach ($humidity->getSensorDatas() as $sensorData) {
                $timestamps[] = $sensorData->getCapturedAt()->format('Y-m-d H:i:s'); // Le timestamp
                $humidityValues[] = $sensorData->getData(); // Le niveau d'humidité
            }
        }

        // Construire le graphique d'humidité
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $timestamps, // Les labels du graphique (timestamps)
            'datasets' => [
                [
                    'label' => 'Humidity (%)', // Légende du graphique
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)', // Couleur de fond
                    'borderColor' => 'rgba(153, 102, 255, 1)', // Couleur de la ligne
                    'data' => $humidityValues, // Données d'humidité
                    'fill' => false, // Pas de remplissage sous la ligne
                    'borderWidth' => 2, // Largeur de la ligne
                    'pointBackgroundColor' => 'rgba(153, 102, 255, 1)', // Couleur des points
                    'pointRadius' => 5, // Taille des points
                    'tension' => 0.4, // Lissage de la courbe
                ],
            ],
        ]);

        // Ajouter les limites min et max sur l'axe Y (si vous avez ces valeurs)
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0, // Valeur min de l'humidité
                    'suggestedMax' => 100, // Valeur max de l'humidité
                ],
            ],
        ]);

        // Passer les données à la vue Twig pour le rendu
        return $this->render('chart/chartHumidity.html.twig', [
            'minHumidity' => $humidities[0]->getMinHumidity(), // Limite min
            'maxHumidity' => $humidities[0]->getMaxHumidity(), // Limite max
            'humidities' => json_encode($humidityValues), // Données JSON encodées pour Twig
            'timestamps' => json_encode($timestamps), // Timestamps JSON encodés
            'chart' => $chart, // Le graphique construit
        ]);
    }
}
