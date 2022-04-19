<?php

namespace App\Controller;

use App\Entity\Personnell;
use App\Entity\User;
use App\Form\EmployeeType;
use App\Repository\PersonnellRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employeeList", name="employeeList")
     */
    public function list(): Response
    {
        $employees = $this->getDoctrine()->getManager()->getRepository(Personnell::class)->findAll();
        return $this->render('employees/employee/index.html.twig',[
            'controller_name' => 'EmployeeController',
            'employeeList'=>$employees,
        ]);


    }
    /**
     * @Route("/addEmployee", name="addEmployee")
     */
    public function addEmploye( Request $request)
    {
        $employee = new Personnell();
        $form=$this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request );
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        if ($form->isSubmitted()) {
            $em= $this->getDoctrine()->getManager();
            // On récupère les images transmises
            $image = $form->get('image')->getData();


            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('brochures_directory'),
                $fichier
            );
            $employee->setImage($fichier);
            $em->persist($employee);
            $em->flush() ;
            return $this->redirectToRoute('employeeList') ;
        }
        return $this->render('employees/employee/addEmployee.html.twig', [
            'form' => $form->createView(),
            'users'=>$users,
        ]);
    }
    /**
     * @Route("/editEmployee/{id}", name="editEmployee")
     */
    public function editEmploye( $id,PersonnellRepository $repository,Request $request)
    {
        $employee=$repository->find($id);
        $editform=$this->createForm(EmployeeType::class,$employee);
        $editform->handleRequest($request);
        if ($editform->isSubmitted()&& $editform->isValid() ){
            $em= $this->getDoctrine()->getManager();
            $image = $editform->get('image')->getData();


            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('brochures_directory'),
                $fichier
            );
            $employee->setImage($fichier);
            $em->flush() ;
            return $this->redirectToRoute('employeeList') ;
        }
        return $this->render('employees/employee/addEmployee.html.twig', [
            'form' => $editform->createView(),
        ]);
    }
    /**
     * @Route("/deleteEmployee/{id}", name="deleteEmployee")
     */

    public function deleteEmployer($id){

        $em = $this->getDoctrine()->getManager();
        $employee =$em->getRepository(Personnell::class)->find($id);
        $em->remove($employee);
        $em->flush();
        return $this->redirectToRoute('employeeList');
    }


}



























