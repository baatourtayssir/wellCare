<?php

namespace App\Entity;

use App\Repository\HumidityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HumidityRepository::class)]
class Humidity extends Sensor
{


    #[ORM\Column]
    private ?float $humidityLevel = null;


    public function getHumidityLevel(): ?float
    {
        return $this->humidityLevel;
    }

    public function setHumidityLevel(float $humidityLevel): static
    {
        $this->humidityLevel = $humidityLevel;

        return $this;
    }
}
