<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Entity\OrderLogs;
use App\Entity\OrderLogsInterface;
use App\Entity\User;
use App\Repository\OrderLogsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\Security\Core\Security;

class OrderLogsService
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * OrderLogsService constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager,Security $security)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function createOrderLogs(OrderInterface $order,string $orderState): void
    {

        if(null === $order){
            return;
        }


        $orderLogs = new OrderLogs();

        /** @var User $user */
        $user = $this->security->getUser();

        /** @var Order $realOrder */
        $realOrder = $order;

        $orderLogs->setState($orderState);
        $orderLogs->setOrderDetails($realOrder);
        $orderLogs->setUserDetails($user);

        $this->entityManager->persist($orderLogs);
        $this->entityManager->flush();

    }

    public function fetchOrderLogs(Order $order)
    {
        /** @var OrderLogsInterface $orderlogs */
        $orderlogs = $this->entityManager->getRepository(OrderLogs::class)->findBy(['orderDetails'=>$order->getId()]);

        if(empty($orderlogs)){
            throw new QueryException(sprintf("No logs for order #%d ",$order->getId()));
        }

        return $orderlogs;

    }
}
