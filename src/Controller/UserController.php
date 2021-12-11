<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use function Symfony\Component\Translation\t;

class UserController extends AbstractController
{
    /**
     * @var EmailVerifier
     */
    private $emailVerifier;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfToken;


    /**
     * UserController constructor.
     *
     */
    public function __construct(EmailVerifier $emailVerifier, EntityManagerInterface $entityManager,CsrfTokenManagerInterface $csrfToken)
    {
        $this->emailVerifier = $emailVerifier;
        $this->entityManager = $entityManager;
        $this->csrfToken = $csrfToken;
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

    }

    public function editUser(Request $request,User $user, UserPasswordHasherInterface $userPasswordHasher)
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRole = $form->get('roles')->getData();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles([$userRole]);

            $this->entityManager->persist($user);
            $this->entityManager->flush();


            return $this->redirectToRoute('create_user');
        }

        return $this->render('registration/editUser.html.twig',[
            "registrationForm" => $form->createView(),
            "page_title" => "Edit User"
        ]);
    }


    public function deleteUser(Request $request,User $user)
    {

        /** @var CsrfToken $submittedToken */
        $submittedToken = $request->get('_csrf_token');

        if ($this->csrfToken->isTokenValid($this->csrfToken->getToken($submittedToken)))
        {
            // Do the deletion stuff
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            return $this->json('deleted',200);
        }
        throw new \Exception(sprintf("Failed to delete user"));
    }
}

