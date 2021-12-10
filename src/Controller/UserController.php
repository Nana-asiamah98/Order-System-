<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;


    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function allUsers(Request $request, DataTableFactory $dataTableFactory): Response
    {

        $table = $dataTableFactory->create()
            ->add('firstName', TextColumn::class)
            ->add('email', TextColumn::class)
            ->createAdapter(ArrayAdapter::class, [
                ['firstName' => 'Jude', 'email' => 'jude@jude.com'],
                ['firstName' => 'Admin', 'email' => 'admin@admin.com'],

            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('registration/createUser.html.twig',[
            'notable' => $table
        ]);

//        /** @var User $users */
        /*$users = $this->userRepository->findAll();
        return $this->json([
            'users' => $users
        ]);*/
    }
}
