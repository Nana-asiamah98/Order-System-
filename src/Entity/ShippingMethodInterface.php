<?php

namespace App\Entity;


interface ShippingMethodInterface
{
    public function getId(): ?int;

    public function getShippingCompany(): ?string;

    public function setShippingCompany(?string $shippingCompany): \App\Entity\ShippingMethod;

    public function getTrackingNumber(): ?string;

    public function setTrackingNumber(?string $trackingNumber): \App\Entity\ShippingMethod;

    public function getDocumentPath(): ?string;

    public function setDocumentPath(?string $documentPath): \App\Entity\ShippingMethod;

    public function getOrderDetails(): ?Order;

    public function setOrderDetails(?Order $orderDetails): \App\Entity\ShippingMethod;
}