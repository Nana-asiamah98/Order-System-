<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PickingDepartmentController extends AbstractController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;


    /**
     * PickingDepartmentController constructor.
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request  $request, PaginatorInterface $paginator):Response
    {

        $receivedOrders = $this->orderRepository->findReceivedOrders();

        /*Paginate the result*/
        $receivedOrders = $paginator->paginate(
          $receivedOrders,
            $request->query->getInt('page',1),
            5
        );

        return $this->render('department/pickingDepartment.html.twig',[
            "orders" => $receivedOrders,
            "department_name" => "Picking Department"
        ]);
    }

    public function showOrder(Order $order)
    {
        $requestedOrder = $this->orderRepository->find($order);
        dump($requestedOrder);

        return $this->render('department/viewOrder.html.twig',[
            "order" => $requestedOrder,
            "department_name" => "Picking Department"
        ]);

    }


}