<?php

namespace App\Controller;

use App\Entity\Clientinfo;
use App\Entity\Panier;
use App\Entity\Platt;
use App\Form\FormPanierType;
use App\Repository\OrderRepository;
use App\Repository\PanierRepository;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class PanierController extends Controller
{
    /**
     * @Route("/panier", name="app_panier")
     */
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
    /**
     * @param PanierRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/panier/AfficheP" , name="AfficheP")
     */
    public function Affiche(PanierRepository $repository , PaginatorInterface $paginator,Request $request){

        $allpanier=$repository->findAll();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
//    /**
//     * @param PanierRepository $repository
//     * @return \Symfony\Component\HttpFoundation\Response
//     * @Route("/panier/Affichefront" , name="Affichefront")
//     */
//    public function Affichefront(PanierRepository $repository, PaginatorInterface $paginator,Request $request){
//        $userr=$this->getUser()->getUsername();
//        $allpanier=$repository->findByclient($userr);
//        $panierr = $paginator->paginate(
//        // Doctrine Query, not results
//            $allpanier,
//            // Define the page parameter
//            $request->query->getInt('page', 1),
//            // Items per page
//            3
//        );
//        return $this->render('panier/Affichagefront.html.twig',['panierr'=>$panierr]);
//    }
    /**
     * @Route("/Supp/{id}" ,  name="supp")
     */
    public function Delete( Panier $panier):Response{

        $em=$this->getDoctrine()->getManager();
        $em->remove($panier);
        $em->flush();
        $this->addFlash(
            'info',
            'commande Supprimée'
        );
    /*$flashy->success('Event created!', 'http://your-awesome-link.com');*/
        return $this->redirectToRoute('AfficheP')  ;

    }
    /**
     * @Route("panier/Update/{id}",name="update")
     */
    function Update(PanierRepository $repository, $id , \Symfony\Component\HttpFoundation\Request $request){
        $panier=$repository->find($id);
        $form=$this->createForm(FormPanierType::class,$panier);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                'info',
                'commande Modifié'
            );
            return $this->redirectToRoute("AfficheP");

        }

        return $this->render('panier/updatep.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/affrefd", name="refdesc")
     */
    function OrderByQundescSQL(PanierRepository $repository, PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByQuntdesc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/Qun", name="Qun")
     */
    function OrderByQunAscSQL(PanierRepository $repository, PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByQuntasc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/price", name="price")
     */
    function OrderByPrixdescSQL(PanierRepository $repository, PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByprixtdesc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/prix", name="prix")
     */
    function OrderByPrixAscSQL(PanierRepository $repository , PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByprixtasc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/id", name="id")
     */
    function OrderByiddescSQL(PanierRepository $repository, PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByiddesc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/idd", name="idd")
     */
    function OrderByidAscSQL(PanierRepository $repository , PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByidasc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
    /**
     * @Route("student/search", name="search")
     */
    public function rechercher(PanierRepository $repository,Request $request , PaginatorInterface $paginator): Response
    {
        $nscrech = $request->get('search');
        $allpanier = $repository->SearchNSC($nscrech);
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',
            ['panier' => $allpanier]);

    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/id", name="plat")
     */
    function OrderByidplatdescSQL(PanierRepository $repository , PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByidplatdesc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }
    /**
     * @param PanierRepository $repository
     * @return Response
     * @Route("panier/idd", name="platt")
     */
    function OrderByidplatAscSQL(PanierRepository $repository , PaginatorInterface $paginator,Request $request){
        $allpanier=$repository->OrderByidplatasc();
        $panier = $paginator->paginate(
        // Doctrine Query, not results
            $allpanier,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('panier/AfficheP.html.twig',['panier'=>$panier]);
    }

    /**
     * @Route("/listePanier ", name="listePanier")
     */
    public function searchPanier(Request $request,NormalizerInterface $Normalizer , PanierRepository $panierRepository)
    {
//        $repository = $this->getDoctrine()->getRepository(Panier::class);
        $requestString=$request->get('searchValue');
        $panier= $panierRepository->SearchPanier($requestString);
        $jsonContent = $Normalizer->normalize($panier, 'json',['groups'=>'paniers']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }
}
