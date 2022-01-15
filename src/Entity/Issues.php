<?php

namespace App\Entity;

use App\Repository\IssuesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IssuesRepository::class)
 */
class Issues implements IssuesInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $orderIssue;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class)
     */
    private $orderDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOrderIssue(): ?string
    {
        return $this->orderIssue;
    }

    public function setOrderIssue(?string $orderIssue): self
    {
        $this->orderIssue = $orderIssue;

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
