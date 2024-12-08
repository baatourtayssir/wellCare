<?php

namespace App\Entity;

use App\Repository\HumidityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HumidityRepository::class)]
class Humidity extends Sensor
{
    #[ORM\Column]
    private ?float $minHumidity = null;

    #[ORM\Column]
    private ?float $maxHumidity = null;

    public function getMinHumidity(): ?float
    {
        return $this->minHumidity;
    }

    public function setMinHumidity(float $minHumidity): static
    {
        $this->minHumidity = $minHumidity;

        return $this;
    }

    public function getMaxHumidity(): ?float
    {
        return $this->maxHumidity;
    }

    public function setMaxHumidity(float $maxHumidity): static
    {
        $this->maxHumidity = $maxHumidity;

        return $this;
    }
}
