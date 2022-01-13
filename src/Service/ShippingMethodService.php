<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Entity\ShippingMethod;
use App\Entity\ShippingMethodInterface;
use App\Events\OrderLogsEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShippingMethodService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;


    /**
     * ShippingMethodService constructor.
     * @param EntityManagerInterface $entityManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $entityManager,EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function storeOrderShippingInfo(ShippingMethodInterface $shippingMethod): ?ShippingMethodInterface
    {
        if(null === $shippingMethod){
            throw new \Exception("Shipping Method is null");
        }

        $this->entityManager->persist($shippingMethod);
        $this->entityManager->flush();
        $this->orderLogsEvent($shippingMethod->getOrderDetails(),Order::ORDER_SHIPPED);

        return $shippingMethod;
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
