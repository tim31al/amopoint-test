<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;


/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitorRepository")
 * @ORM\Table(name="visitors", indexes={@Index(name="city_idx", columns={"city"})})
 * @ORM\HasLifecycleCallbacks()
 */
class Visitor
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $ip;

    /**
     * @ORM\Column(type="string")
     */
    private string $city;

    /**
     * @ORM\Column(type="string")
     */
    private string $device;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $dateVisit;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getDevice(): string
    {
        return $this->device;
    }

    /**
     * @param string $device
     */
    public function setDevice(string $device): self
    {
        $this->device = $device;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateVisit(): \DateTime
    {
        return $this->dateVisit;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setDateVisit(): void
    {
        $this->dateVisit = new \DateTime('now');
    }
}

