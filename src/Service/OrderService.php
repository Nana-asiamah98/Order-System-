<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class OrderService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SluggerInterface
     */
    private $slugger;
    /**
     * @var ContainerInterface
     */
    private $container;
    private $targetDirectory;


    /**
     * OrderService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     * @param SluggerInterface $slugger
     */
    public function __construct(EntityManagerInterface $entityManager,ContainerInterface $container, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
        $this->container = $container;
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
            return true;
        }
        return false;

    }



}