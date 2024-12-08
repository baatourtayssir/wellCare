<?php

namespace App\Entity;

use App\Repository\SensorDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorDataRepository::class)]
class SensorData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $data = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $capturedAt = null;

    #[ORM\ManyToOne(inversedBy: 'sensorDatas')]
    private ?Sensor $sensor = null;

    public function __construct()
    {
        // Initialiser capturedAt avec la date et l'heure actuelles lors de la création d'une nouvelle instance
        $this->capturedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getCapturedAt(): ?\DateTimeInterface
    {
        return $this->capturedAt;
    }

    public function setCapturedAt(\DateTimeInterface $capturedAt): static
    {
        $this->capturedAt = $capturedAt;

        return $this;
    }

    public function getSensor(): ?Sensor
    {
        return $this->sensor;
    }

    public function setSensor(?Sensor $sensor): static
    {
        $this->sensor = $sensor;

        return $this;
    }
}
