<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLogsInterface;
use App\Service\OrderLogsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class OrderLogsController extends AbstractController
{

    /**
     *
     * @param OrderLogsService $logsService
     * @param Request $request
     * @param Order $order
     * @return Response
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function showLogs(OrderLogsService $logsService,Request $request,Order $order): Response
    {
        $orderLogs = $logsService->fetchOrderLogs($order);
        dump($orderLogs);

        return $this->render('order_logs/orderlogs.html.twig', [
            'controller_name' => 'OrderLogsController',
            'orderLogs' => $orderLogs
        ]);
    }
}
