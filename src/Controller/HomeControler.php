<?php

namespace App\Controller;

use App\Entity\ReportUser;
use App\Form\ProfileType;
use App\Form\RegistrationFormType1;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class HomeControler extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route ("/home", name ="homePage")
     */
    public function homePage():Response
    {
        $user= $this->getUser();

        return $this->render('pages/index.html.twig' , ['user' => $user]);

    }
    /**
     * @IsGranted("ROLE_USER", "ROLE_ADMIN")
     * @Route ("/profile", name ="profile")
     */
    public function profile():Response
    {   $user= $this->getUser();
        if (!$user){
            $this->addFlash('info', 'You need to login first');
        }
        return $this->render('Users/userProfile.html.twig', [
            'user' => $user]);

    }

    /**
     *@Route("/editProfile/{id}", name="editProfile")
     */
    public function editProfile( $id,UserRepository $repository,Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user=$repository->find($id);
        $editform=$this->createForm(ProfileType::class, $this->getUser());
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
            return $this->redirectToRoute('profile') ;
        }
        return $this->render('Users/editProfile.html.twig', [
            'f' => $editform->createView(),

        ]);
    }

}