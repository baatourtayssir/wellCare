<?php

namespace App\Entity;

use App\Repository\ConnectedDeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectedDeviceRepository::class)]
class ConnectedDevice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $deviceId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isOn = null;

    #[ORM\ManyToOne(inversedBy: 'connectedDevices')]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Sensor::class, mappedBy: 'connectedDevice')]
    private Collection $sensors;

    public function __construct()
    {
        $this->sensors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function setDeviceId(string $deviceId): static
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Sensor>
     */
    public function getSensors(): Collection
    {
        return $this->sensors;
    }

    public function addSensor(Sensor $sensor): static
    {
        if (!$this->sensors->contains($sensor)) {
            $this->sensors->add($sensor);
            $sensor->setConnectedDevice($this);
        }

        return $this;
    }

    public function removeSensor(Sensor $sensor): static
    {
        if ($this->sensors->removeElement($sensor)) {
            // set the owning side to null (unless already changed)
            if ($sensor->getConnectedDevice() === $this) {
                $sensor->setConnectedDevice(null);
            }
        }

        return $this;
    }
}
