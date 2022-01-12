<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Events\OrderLogsEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;


    /**
     * OrderService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     * @param SluggerInterface $slugger
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $entityManager,
                                ContainerInterface $container,
                                SluggerInterface $slugger,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createOrder(Order $requestedOrder): ?OrderInterface
    {
        $this->entityManager->persist($requestedOrder);
        $this->entityManager->flush();
        $this->orderLogsEvent($requestedOrder,OrderInterface::ORDER_RECEIVED);
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
            $this->orderLogsEvent($order,OrderInterface::ORDER_PROCESSING);
            return true;
        }

        return false;
    }


    public  function isOrderMarked(Order $order): bool
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

    private function orderLogsEvent(Order $order,string $orderState):void
    {

        if(null === $order)
        {
            return ;
        }

        /*Event Dispatcher Setup*/
        $orderLogs = new OrderLogsEvent($order,$orderState);

        $this->eventDispatcher->dispatch($orderLogs,OrderLogsEvent::NAME);
    }


}