<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * OrderService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrder(Order $requestedOrder): ?OrderInterface
    {
        $this->entityManager->persist($requestedOrder);
        $this->entityManager->flush();
        return $requestedOrder;
    }
}