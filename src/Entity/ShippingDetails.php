<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\ShippingDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShippingDetailsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ShippingDetails
{
    use TimeStampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $method;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="shipping")
     */
    private $orderDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getOrderDetails(): ?Order
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(?Order $orderDetails): self
    {
        $this->orderDetails = $orderDetails;

        return $this;
    }
}
