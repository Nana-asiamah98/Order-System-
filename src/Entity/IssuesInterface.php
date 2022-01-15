<?php

namespace App\Entity;


interface IssuesInterface
{
    const ITEM_MISSING = "ITEM_MISSING";
    const ITEM_DAMAGED = "ITEM_DAMAGED";
    const ITEM_MISMATCHED = "ITEM_MISMATCHED";
    const TOKEN = '_token';
    public function getId(): ?int;

    public function getDescription(): ?string;

    public function setDescription(?string $description): \App\Entity\Issues;

    public function getOrderIssue(): ?string;

    public function setOrderIssue(?string $orderIssue): \App\Entity\Issues;

    public function getOrderDetails(): ?Order;

    public function setOrderDetails(?Order $orderDetails): \App\Entity\Issues;
}
