<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/department", name="department")
     */
    public function index(): Response
    {
        return $this->render('department/index.html.twig', [
            'controller_name' => 'DepartmentController',
        ]);
    }

    public function pickingDepartment()
    {
        return $this->render('department/pickingDepartment.html.twig',[
            "department_name" => "Picking Department"
        ]);
    }

    public function shippingDepartment()
    {
        return $this->render('department/shippingDepartment.html.twig',[
            "department_name" => "Shipping Department"
        ]);
    }

    public function managementDepartment()
    {
        return $this->render('department/managementDepartment.html.twig',[
            "department_name" => "Management Department"
        ]);
    }
}
