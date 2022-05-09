<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Clientinfo;
use App\Entity\Blog;
use App\Form\AvisfType;
use App\Form\AvisType;
use App\Form\BlogsType;
use App\Repository\AvisRepository;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="app_avis")
     */
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }
    /**
     * @Route("/affavis", name="affavis")
     */

    public function afficher(AvisRepository $repository)
    {
        $avis = $repository->findAll();

        return $this->render('avis/Affiche.html.twig', ['av' => $avis]);

    }
    /**
     * @Route("/affavisf", name="affavisf")
     */

    public function afficherf(AvisRepository $repository)
    {
        $avis = $repository->findAll();
        return $this->render('avis/affichef.html.twig', ['av' => $avis]);

    }

    /**
     * @Route ("/a/{id}",name="a")
     */
    public function supprimer($id, AvisRepository $repository)
    {
        $av = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($av);
        $em->flush();
        //$flashy->warning('Suppression Avec Succès!');
        return $this->redirectToRoute('affavis');
    }
    /**
     * @Route ("/af/{id}",name="af")
     */
    public function supprimerf($id, AvisRepository $repository)
    {
        $av = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($av);

        $em->flush();
        //$flashy->warning('Suppression Avec Succès!');

        return $this->redirectToRoute('affavisf');
    }
    /**
     * @Route ("/avis/adda",name="adda")
     */

    public function add(Request $request)
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($avis);


            return $this->redirectToRoute('affavis');
        }
        return $this->render('avis/Adda.html.twig', [
            'forma' => $form->createView()
        ]);

    }

    /**
     * @Route ("/avis/updatea/{id}",name="updatea")
     */
    public function update(AvisRepository $repository, $id, Request $request)
    {
        $avis = $repository->find($id);
        $form = $this->createForm(AvisType::class, $avis);
        $form->add('update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affavis");
        }
        return $this->render('avis/updatea.html.twig', [
            'formv' => $form->createView()
        ]);
    }
    /**
     * @Route ("/avis/updateaf/{id}",name="updateaf")
     */
    public function updatef(AvisRepository $repository, $id, Request $request)
    {
        $avis = $repository->find($id);
        $form = $this->createForm(AvisfType::class, $avis);
        $form->add('update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affavisf");
        }
        return $this->render('avis/updateaf.html.twig', [
            'formv' => $form->createView()
        ]);
    }

    function badwords($message){
        $badwords = array("lame","douche","careless","fuck");
        $filter = array("****","***","******","****");
        $message = str_replace($badwords,$filter,$message);
        return $message;

    }
    /**
     * @Route ("/avis/addaff",name="addaff")
     */
    public function addf(Request $request)
    {
        $avis = new Avis();
        $form = $this->createForm(AvisfType::class, $avis);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $avis->getDescriptionavis();
            $filtredMessage = $this->badwords($message);
            $avis->setDescriptionavis($filtredMessage);
            $avis->setDateavis(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();

            return $this->redirectToRoute('affavisf');
        }
        return $this->render('avis/Addaf.html.twig', [
            'formaf' => $form->createView()
        ]);

    }


    /**
     * @Route ("/avis/addaviss",name="addaviss")
     */

    public function addaviss(Request $request,MailerInterface $mailer)
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $avis->getDescriptionavis();
            $filtredMessage = $this->badwords($message);
            $avis->setDescriptionavis($filtredMessage);
            $avis->setDateavis(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);

            $em->flush();
            //$flashy->success('Ajout Avec Succès!');

            $em->flush();
            $message = (new Email())
                ->from('imen.rezk@esprit.tn')
                ->To('imen.rezk@esprit.tn')
                ->subject('avis ajouté')
                ->html(
                    "Hello,<br><br> un avis  ajouté: ",
                    'text/html'
                )
            ;
            $mailer->send($message);

            return $this->redirectToRoute('affblogf');
        }
        return $this->render('avis/Addaf.html.twig', [
            'formaff' => $form->createView()
        ]);

    }
    /**
         * @Route("/like/{id}", name="like")
         */

        public function like(AvisRepository $repository,$id)
        { $av=new avis();
            $avis = $repository->findAll();
            $av=$repository->find($id);
            $av->setLikee($av->getLikee()+1);
             $em = $this->getDoctrine()->getManager();
                        $em->persist($av);
                        $em->flush();

            return $this->render('avis/affichef.html.twig', ['av' => $avis]);

        }
         /**
                 * @Route("/dislike/{id}", name="dislike")
                 */

                public function dislike(AvisRepository $repository,$id)
                { $av=new avis();
                    $avis = $repository->findAll();
                    $av=$repository->find($id);
                    $av->setDeslike($av->getDeslike()+1);
                     $em = $this->getDoctrine()->getManager();
                                $em->persist($av);
                                $em->flush();

                    return $this->render('avis/affichef.html.twig', ['av' => $avis]);


                }


}
