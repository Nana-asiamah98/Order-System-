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

    /*Picking Department*/
    public function markPickingProduct(Order $order): bool
    {
        if (null === $order) {
            return false;
        }

        /** @var OrderInterface $isOrder */
        $isOrder = $this->entityManager->getRepository(Order::class)->find($order);

        if (null !== $isOrder) {
            $isOrder->setState(OrderInterface::ORDER_PROCESSING);
            $this->entityManager->persist($isOrder);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }

    public function isOrderMarked(Order $order): bool
    {
        if (null === $order) {
            return false;
        }

        /** @var OrderInterface $isOrder */
        $isOrder = $this->entityManager->getRepository(Order::class)->find($order);


        if (null !== $isOrder && $isOrder->getState() === OrderInterface::ORDER_PROCESSING) {
            dd("hrer");
            return true;
        }
        return false;

    }
}