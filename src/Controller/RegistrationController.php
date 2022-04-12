<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/usersList", name="usersList")
     */
    public function usersList(): Response
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('Users/usersPage.html.twig',[
            'controller_name' => 'RegistrationController',
            'users'=>$users,
        ]);
    }
    /**
     * @Route("/editUser/{id}", name="editUser")
     */
    public function editUser( $id,UserRepository $repository,Request $request)
    {
        $user=$repository->find($id);
        $editform=$this->createForm(RegistrationFormType::class,$user);
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
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $em= $this->getDoctrine()->getManager();
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
            return $this->redirectToRoute('app_login');
        }

        return $this->render('Users/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     */

    public function deleteUser($id){

        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('usersList');
    }


}
