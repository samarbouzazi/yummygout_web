<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType1;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController1 extends AbstractController
{
    /**
     *  @IsGranted("ROLE_ADMIN")
     * @Route("/usersList", name="usersList")
     */
    public function usersList(): Response
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('Users/usersPage.html.twig',[
            'controller_name' => 'RegistrationController1',
            'users'=>$users,
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/editUser/{id}", name="editUser")
     */
    public function editUser( $id,UserRepository $repository,Request $request)
    {
        $user=$repository->find($id);
        $editform=$this->createForm(RegistrationFormType1::class,$user);
        $editform->handleRequest($request);
        if ($editform->isSubmitted()&& $editform->isValid() ){
            $em= $this->getDoctrine()->getManager();
            $image = $editform->get('image')->getData();

            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('brochures_directory_user'),
                $fichier
            );
            $user->setImage($fichier);
            $em->flush() ;
            return $this->redirectToRoute('usersList') ;
        }
        return $this->render('Users/editUser.html.twig', [
            'registrationForm' => $editform->createView(),
        ]);
    }


    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     *
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     *
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType1::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);

            //$em= $this->getDoctrine()->getManager();
            // On récupère les images transmises
            $image = $form->get('image')->getData();


            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('brochures_directory_user'),
                $fichier
            );
            $user->setImage($fichier);

            $entityManager->persist($user);
            $entityManager->flush();


            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('bechir.marko@gmail.com', 'Marcos'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('security/confirmation_email.html.twig')

            );
            $this->addFlash('message', 'Confirmation Email was sent');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('Users/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     *
     * @IsGranted("ROLE_ADMIN")
     * @Route("/deleteUser/{id}", name="deleteUser")
     */

    public function deleteUser($id){

        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('usersList');
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_login');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_login');
    }
}
