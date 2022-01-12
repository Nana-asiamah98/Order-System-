<?php


namespace App\EventListener;


use App\Entity\Order;
use App\Events\OrderLogsEvent;
use Doctrine\ORM\Event\LifecycleEventArgs;

class OrderLogsListener
{


    public function postPersist(LifecycleEventArgs $lifecycleEventArgs)
    {
        $entity = $lifecycleEventArgs->getEntity();
        if(!$entity instanceof Order){
            return;
        }
    }

    public function orderOpened(OrderLogsEvent $orderLogsEvent)
    {

    }
}