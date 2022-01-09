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

class ManagementDepartmentController extends AbstractController
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/management/department", name="management_department")
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {

        $managementOrders = $this->orderRepository->findAll();

        /*Paginate the result*/
        $managementOrders = $paginator->paginate(
            $managementOrders,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('department/managementDepartment.html.twig', [
            "orders" => $managementOrders,
            "department_name" => "Management Department"
        ]);
    }
}
