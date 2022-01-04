<?php

namespace App\Entity;


use Doctrine\Common\Collections\Collection;


interface OrderInterface
{
    const ORDER_RECEIVED = "ORDER_RECEIVED";
    const ORDER_CANCELED = "ORDER_CANCELED";
    const ORDER_PROCESSING = "ORDER_PROCESSING";
    const ORDER_READY_TO_SHIP = "ORDER_READY_TO_SHIP";
    const ORDER_SHIPPED = "ORDER_SHIPPED";
    const ORDER_CANCELLED = "ORDER_CANCELLED";

    public function getId(): ?int;

    public function getTotal(): ?float;

    public function setTotal(?float $total): \App\Entity\Order;

    public function getDiscount(): ?float;

    public function setDiscount(?float $discount): \App\Entity\Order;

    public function getState(): ?string;

    public function setState(?string $state): \App\Entity\Order;

    public function getCustomer(): ?User;

    public function setCustomer(?User $customer): \App\Entity\Order;

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection;

    public function addProduct(Product $product): \App\Entity\Order;

    public function removeProduct(Product $product): \App\Entity\Order;

    /**
     * @return Collection|ShippingDetails[]
     */
    public function getShipping(): Collection;

    public function addShipping(ShippingDetails $shipping): \App\Entity\Order;

    public function removeShipping(ShippingDetails $shipping): \App\Entity\Order;
}