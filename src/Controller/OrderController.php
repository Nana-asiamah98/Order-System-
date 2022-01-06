<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Form\OrderType;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends AbstractController
{

    public function testJSon(Request $request, OrderService $orderService)
    {
        $requestedData = json_decode($request->getContent(),true);

        $form = $this->createForm(OrderType::class);
        $form->submit($requestedData);
        if($form->isValid()){

            /** @var OrderInterface $savedOrder */
            $savedOrder = $orderService->createOrder($form->getData());

            return new JsonResponse($form->getData(),Response::HTTP_OK);
        }
        return new JsonResponse("Failed",Response::HTTP_BAD_REQUEST);


    }
}