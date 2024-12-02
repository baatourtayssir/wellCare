<?php

namespace App\Entity;

use App\Repository\SensorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\DBAL\Types\Types;


#[Table(name: "sensor")]
#[InheritanceType("JOINED")]
#[DiscriminatorColumn(name: "type", type: "string")]
#[DiscriminatorMap([
    'sensor' => Sensor::class, 'heartRate' => HeartRate::class, 'temperature' => Temperature::class, 'humidity' => Humidity::class
])]
#[ORM\Entity(repositoryClass: SensorRepository::class)]
abstract class Sensor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sensorId = null;

    #[ORM\Column]
    private ?bool $isOn = null;

    #[ORM\OneToMany(targetEntity: SensorData::class, mappedBy: 'sensor')]
    private Collection $sensorDatas;

    #[ORM\ManyToOne(inversedBy: 'sensors')]
    private ?ConnectedDevice $connectedDevice = null;

    public function __construct()
    {
        $this->sensorDatas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSensorId(): ?string
    {
        return $this->sensorId;
    }

    public function setSensorId(string $sensorId): static
    {
        $this->sensorId = $sensorId;

        return $this;
    }

    public function isIsOn(): ?bool
    {
        return $this->isOn;
    }

    public function setIsOn(bool $isOn): static
    {
        $this->isOn = $isOn;

        return $this;
    }

    /**
     * @return Collection<int, SensorData>
     */
    public function getSensorDatas(): Collection
    {
        return $this->sensorDatas;
    }

    public function addSensorData(SensorData $sensorData): static
    {
        if (!$this->sensorDatas->contains($sensorData)) {
            $this->sensorDatas->add($sensorData);
            $sensorData->setSensor($this);
        }

        return $this;
    }

    public function removeSensorData(SensorData $sensorData): static
    {
        if ($this->sensorDatas->removeElement($sensorData)) {
            // set the owning side to null (unless already changed)
            if ($sensorData->getSensor() === $this) {
                $sensorData->setSensor(null);
            }
        }

        return $this;
    }

    public function getConnectedDevice(): ?ConnectedDevice
    {
        return $this->connectedDevice;
    }

    public function setConnectedDevice(?ConnectedDevice $connectedDevice): static
    {
        $this->connectedDevice = $connectedDevice;

        return $this;
    }
}
