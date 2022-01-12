<?php

namespace App\Entity;


interface OrderLogsInterface
{
    public function getId(): ?int;

    public function getOrderDetails(): ?Order;

    public function setOrderDetails(?Order $orderDetails): \App\Entity\OrderLogs;

    public function getUserDetails(): ?User;

    public function setUserDetails(?User $userDetails): \App\Entity\OrderLogs;

    public function getState(): ?string;

    public function setState(?string $state): \App\Entity\OrderLogs;
}