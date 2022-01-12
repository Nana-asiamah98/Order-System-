<?php


namespace App\Events;


use App\Entity\Order;
use App\Entity\OrderLogs;
use Symfony\Contracts\EventDispatcher\Event;


class OrderLogsEvent extends Event
{

    public const NAME = "order_logs.opened";
    /**
     * @var Order
     */
    protected $orderLogs;
    /**
     * @var string
     */
    protected $orderState;

    /**
     * OrderLogsEvent constructor.
     * @param Order $orderLogs
     * @param string $orderState
     */
    public function __construct(Order $orderLogs,string $orderState)
    {
        $this->orderLogs = $orderLogs;
        $this->orderState = $orderState;
    }

    /**
     * @return Order
     */
    public function getOrderLogs(): ?Order
    {
        return $this->orderLogs;
    }

    /**
     * @return string
     */
    public function getOrderState(): string
    {
        return $this->orderState;
    }




}