<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="product")
     */
    private $orderDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

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
