<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Form\BoxType;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Service\OrderService;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PickingDepartmentController extends AbstractController
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
     * @var OrderService
     */
    private $orderService;


    /**
     * PickingDepartmentController constructor.
     */
    public function __construct(OrderRepository $orderRepository, EntityManagerInterface $entityManager, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
        $this->orderService = $orderService;
    }

    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        $receivedOrders = $this->orderRepository->findOrders(OrderInterface::ORDER_RECEIVED);

        /*Paginate the result*/
        $receivedOrders = $paginator->paginate(
            $receivedOrders,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('department/pickingDepartment.html.twig', [
            "orders" => $receivedOrders,
            "department_name" => "Picking Department"
        ]);
    }






}