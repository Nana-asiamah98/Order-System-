<?php


namespace App\EventSubscriber;


use App\Entity\OrderInterface;
use App\Entity\OrderLogsInterface;
use App\Events\OrderLogsEvent;
use App\Service\OrderLogsService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderLogsSubscriber implements EventSubscriberInterface
{
    /**
     * @var OrderLogsService
     */
    private $orderLogs;


    /**
     * OrderLogsSubscriber constructor.
     * @param OrderLogsService $orderLogs
     */
    public function __construct(OrderLogsService $orderLogs)
    {
        $this->orderLogs = $orderLogs;
    }

    public static function getSubscribedEvents()
    {
        return [
          OrderLogsEvent::NAME =>  "orderLogsOpened"
        ];
    }

    public function orderLogsOpened(OrderLogsEvent $orderLogsEvent)
    {
        /** @var OrderInterface $order */
        $order = $orderLogsEvent->getOrderLogs();

        $this->orderLogs->createOrderLogs($order,$orderLogsEvent->getOrderState());
    }


}