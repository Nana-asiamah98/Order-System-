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

    public function showOrder(Order $order, Request $request)
    {
        $requestedOrder = $this->orderRepository->find($order);
        $form = $this->createForm(BoxType::class);
        $form->handleRequest($request);

        $submittedToken = $request->request->get('box');
        if (null !== $request->request->get('box')) {
            $submittedToken = $request->request->get('box')['_token'];
        }


        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid("box_id", $submittedToken)) {
            $order->setBoxId($request->request->get('box')['boxId']);
            $order->setState(OrderInterface::ORDER_READY_TO_SHIP);
            $this->entityManager->persist($order);
            $this->entityManager->flush();
            $this->addFlash('success', "Order Has Been Moved To The Shipping Department");
            return $this->redirectToRoute('picking_departments');
        }

        return $this->render('department/viewOrder.html.twig', [
            "order" => $requestedOrder,
            "department_name" => "Picking Department",
            "form" => $form->createView(),
        ]);

    }

    public function markOrder(Order $order)
    {
        $result = $this->orderService->markPickingProduct($order);
        if ($result) {
            return new JsonResponse("Successful", 200);
        }
        return new JsonResponse("Error", 400);
    }

    public function isOrderMarkedAsProcessing(Order $order)
    {
        $result = $this->orderService->isOrderMarked($order);

        if ($result) {
            return new JsonResponse($result, 200);
        }

        return new JsonResponse($result, 400);
    }


}