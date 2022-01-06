<?php


namespace App\Controller;


use App\Entity\OrderInterface;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PickingDepartmentController extends AbstractController
{

    public function index(OrderRepository $orderRepository):Response
    {

        $receivedOrders = $orderRepository->findBy(['state'=> OrderInterface::ORDER_RECEIVED]);
        dump($receivedOrders);


        return $this->render('department/pickingDepartment.html.twig',[
            "orders" => $receivedOrders,
            "department_name" => "Picking Department"
        ]);
    }


}