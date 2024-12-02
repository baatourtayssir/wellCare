<?php

namespace App\Entity;

use App\Repository\TemperatureRepository;
use App\Entity\Sensor;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TemperatureRepository::class)]
class Temperature extends Sensor
{
 

    #[ORM\Column]
    private ?float $minTemperature = null;

    #[ORM\Column]
    private ?float $maxTemperature = null;


    public function getMinTemperature(): ?float
    {
        return $this->minTemperature;
    }

    public function setMinTemperature(float $minTemperature): static
    {
        $this->minTemperature = $minTemperature;

        return $this;
    }

    public function getMaxTemperature(): ?float
    {
        return $this->maxTemperature;
    }

    public function setMaxTemperature(float $maxTemperature): static
    {
        $this->maxTemperature = $maxTemperature;

        return $this;
    }
}
