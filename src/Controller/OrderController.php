<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Entity\ShippingMethod;
use App\Entity\ShippingMethodInterface;
use App\Form\BoxType;
use App\Form\OrderType;
use App\Form\ShippingMethodType;
use App\Repository\OrderRepository;
use App\Service\FileUploadService;
use App\Service\OrderService;
use App\Service\ShippingMethodService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
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
     * @var ShippingMethodService
     */
    private $shippingMethodService;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;


    /**
     * PickingDepartmentController constructor.
     */
    public function __construct(
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager,
        OrderService $orderService,
        ShippingMethodService $shippingMethodService,
        FileUploadService $fileUploadService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
        $this->orderService = $orderService;
        $this->shippingMethodService = $shippingMethodService;
        $this->fileUploadService = $fileUploadService;
    }


    public function testJSon(Request $request, OrderService $orderService, SerializerInterface $serializer)
    {
        $requestedData = json_decode($request->getContent(), true);

        $form = $this->createForm(OrderType::class);
        $form->submit($requestedData);
        if ($form->isValid()) {

            /** @var OrderInterface $savedOrder */
            $savedOrder = $orderService->createOrder($form->getData());

            return new Response($serializer->serialize($savedOrder, 'json', ['groups' => 'show_order']), Response::HTTP_OK);
        }
        return new JsonResponse("Failed", Response::HTTP_BAD_REQUEST);


    }

    public function showOrder(Order $order, Request $request)
    {
        $requestedOrder = $this->orderRepository->find($order);

        $form = $this->createForm(BoxType::class);
        $form->handleRequest($request);

        $shippingMethodForm = $this->createForm(ShippingMethodType::class);
        $shippingMethodForm->handleRequest($request);

        $submittedToken = $request->request->get('box') !== null ? $request->request->get('box') : $request->request->get('shipping_method') ;
        if (null !== $request->request->get('box')) {
            $submittedToken = $request->request->get('box')['_token'];
        }elseif(null !== $request->request->get('shipping_method')){
            $submittedToken =  $request->request->get('shipping_method')['_token'];
        }

        /*Forms Validation and Submission*/
        /*Box ID and ORDER_READY_TO_SHIP*/
        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid("box_id", $submittedToken)) {
            $boxId = $request->request->get('box')['boxId'];
            $this->orderService->readyToShip($order,$boxId);
            $this->addFlash('success', "Order Has Been Moved To The Shipping Department");
            return $this->redirectToRoute('picking_departments');
        }

        if ($shippingMethodForm->isSubmitted() && $shippingMethodForm->isValid() && $this->isCsrfTokenValid("shipping_method", $submittedToken)) {

            /** @var UploadedFile $fileUpload */
            $fileUpload = $shippingMethodForm->get('documentPath')->getData();

            $fileUploadedName = $this->fileUploadService->fileUpload($fileUpload);

            /** @var ShippingMethodInterface $shippingMethodData */
            $shippingMethodData = $shippingMethodForm->getData();
            $shippingMethodData->setDocumentPath($fileUploadedName);
            $order->setState(Order::ORDER_SHIPPED);
            $shippingMethodData->setOrderDetails($order);

            try {
                $shippingMethodData = $this->shippingMethodService->storeOrderShippingInfo($shippingMethodData);
            } catch (\Exception $e) {
                throw new \LogicException(sprintf("The error is from '%s'",$e));
            }

            $this->addFlash('success', "Order Has Been Moved To The Management Department");
            return $this->redirectToRoute('shipping_departments');
        }

        return $this->render('department/viewOrder.html.twig', [
            "order" => $requestedOrder,
            "department_name" => "Picking Department",
            "form" => $form->createView(),
            "shippingMethodForm" => $shippingMethodForm->createView()
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
