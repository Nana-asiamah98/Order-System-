<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderLogsController extends AbstractController
{
    /**
     * @Route("/order/logs", name="order_logs")
     */
    public function index(): Response
    {
        return $this->render('order_logs/orderlogs.html.twig', [
            'controller_name' => 'OrderLogsController',
        ]);
    }
}
