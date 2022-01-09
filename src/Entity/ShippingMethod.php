<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\ShippingMethodRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShippingMethodRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ShippingMethod implements ShippingMethodInterface
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
    private $shippingCompany;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $trackingNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documentPath;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, cascade={"persist", "remove"})
     */
    private $orderDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShippingCompany(): ?string
    {
        return $this->shippingCompany;
    }

    public function setShippingCompany(?string $shippingCompany): self
    {
        $this->shippingCompany = $shippingCompany;

        return $this;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(?string $trackingNumber): self
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    public function getDocumentPath(): ?string
    {
        return $this->documentPath;
    }

    public function setDocumentPath(?string $documentPath): self
    {
        $this->documentPath = $documentPath;

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
