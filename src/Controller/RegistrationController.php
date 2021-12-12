<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{

    private EmailVerifier $emailVerifier;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfToken;

    public function __construct(EmailVerifier $emailVerifier, EntityManagerInterface $entityManager,CsrfTokenManagerInterface $csrfToken)
    {
        $this->emailVerifier = $emailVerifier;
        $this->entityManager = $entityManager;
        $this->csrfToken = $csrfToken;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('cikix82526@kingsready.com', 'Cikix'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }

    public function createUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, DataTableFactory $dataTableFactory)
    {


        $table = $dataTableFactory->create()
            ->add('firstName', TextColumn::class)
            ->add('email', TextColumn::class)
            ->createAdapter(ORMAdapter::class, [
                'entity' => User::class
            ])
            ->handleRequest($request);


        $table
            ->add('id', TextColumn::class, ['render' => function ($value, $context) {
                return sprintf('<div class="text-center"> 
                            <a href="%s" class="btn btn-warning btn-lg"> 
                                       <i  class="mdi mdi-pen"></i>
                            </a>
                             <button class="btn btn-danger btn-lg deletedUser" id="%d" data-csrf-token="%s" data-remove-url="%s"> 
                                       <i  class="mdi mdi-trash-can"></i>
                            </button>
                            <!--<form action=""  method="post" onsubmit="return confirm()">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_csrf_token" value="">
                                <button  type="submit" class="btn btn-danger btn-lg" id="deleteUser">
                                    <i class="mdi mdi-trash-can"> </i> 
                                </button> 
                            </form>-->
                            
                            
                         </div>',
                    $this->generateUrl('edit_user', ["id" => $value]),
                    $value,
                    $this->csrfToken->refreshToken('remove'),
                    $this->generateUrl('delete_user',["id" => $value])

                );
            }]);

        if ($table->isCallback()) {
            return $table->getResponse();
        }


        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

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

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('admin@admin.com', 'Admin'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            $this->addFlash('success',"User Added Successfully");
            return $this->redirectToRoute('create_user');
        }


        return $this->render('registration/createUser.html.twig', [
            'page_title' => 'User Management',
            'datatable' => $table,
            'registrationForm' => $form->createView()
        ]);
    }
}
