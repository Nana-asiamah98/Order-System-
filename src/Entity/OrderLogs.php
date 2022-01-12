<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\OrderLogsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderLogsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class OrderLogs implements OrderLogsInterface
{

    use TimeStampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderLogs")
     */
    private $orderDetails;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderLogs")
     */
    private $userDetails;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $state;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserDetails(): ?User
    {
        return $this->userDetails;
    }

    public function setUserDetails(?User $userDetails): self
    {
        $this->userDetails = $userDetails;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
