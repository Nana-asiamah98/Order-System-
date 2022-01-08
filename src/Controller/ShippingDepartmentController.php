<?php

namespace App\Controller;

use App\Entity\OrderInterface;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShippingDepartmentController extends AbstractController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ShippingDepartmentController constructor.
     */
    public function __construct(OrderRepository $orderRepository,EntityManagerInterface $entityManager)
    {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
    }



    public function index(Request $request,PaginatorInterface $paginator): Response
    {
        $readyToBeShippedOrders = $this->orderRepository->findOrders(OrderInterface::ORDER_READY_TO_SHIP);

        /*Paginate the result*/
        $readyToBeShippedOrders = $paginator->paginate(
            $readyToBeShippedOrders,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('department/shippingDepartment.html.twig', [
            "orders" => $readyToBeShippedOrders,
            "department_name" => "Shipping Department"
        ]);
    }
}
