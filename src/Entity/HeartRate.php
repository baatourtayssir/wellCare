<?php

namespace App\Entity;

use App\Repository\HeartRateRepository;
use App\Entity\Sensor;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: HeartRateRepository::class)]
class HeartRate extends Sensor
{
   

    #[ORM\Column]
    private ?int $minHeartRate = null;


    #[ORM\Column]
    private ?int $maxHeartRate = null;



    public function getMinHeartRate(): ?int
    {
        return $this->minHeartRate;
    }

    public function setMinHeartRate(int $minHeartRate): static
    {
        $this->minHeartRate = $minHeartRate;

        return $this;
    }

    public function getMaxHeartRate(): ?int
    {
        return $this->maxHeartRate;
    }

    public function setMaxHeartRate(int $maxHeartRate): static
    {
        $this->maxHeartRate = $maxHeartRate;

        return $this;
    }
}
