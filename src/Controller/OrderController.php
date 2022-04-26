<?php

namespace App\Controller;

use App\Entity\Clientinfo;
use App\Entity\Order;
use App\Entity\Panier;
use App\Entity\Platt;
use App\Repository\OrderRepository;
use App\Repository\PanierRepository;
use App\Repository\PlatRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use http\Client;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



/**
 * @Route("/order", name="order_")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="index")
     */
    public function index(SessionInterface $session, PlatRepository $productsRepository ): Response
    {
        $panier = $session->get("panier", []);
        // On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $product = $productsRepository->find($id);
            $dataPanier[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrixPlat() * $quantite;
        }
        return $this->render('order/index.html.twig', compact("dataPanier","total"));
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Platt $product, SessionInterface $session , $id)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getIdplat();

        if (!empty($panier[$id])) {
            $panier[$id]++;

        } else {
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);


        return $this->redirectToRoute("order_index");
    }
    /**
     * @Route("order/remove/{id}", name="remove")
     */
    public function remove(Platt $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getIdplat();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]); //retirer la ligne
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);



        return $this->redirectToRoute("order_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Platt $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getIdplat();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("order_index");
    }
    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("order_index");
    }

    /**
     * @Route("/valider", name="valider")
     * @param PlatRepository $produits
     * @param SessionInterface $session
     */
    public function valider(PlatRepository $productsRepository, SessionInterface $session , PanierRepository $panierRepository , OrderRepository $orderrepository , MailerInterface $mailer)
    {   $total=0;

        $userr=$this->getUser()->getUsername();
        $panier = $session->get('panier', []);
        $data = [];
        foreach($panier as $id => $quantity){
            $produits = $productsRepository->find($id);
            $data[] = [
                'product' => $produits ,
                'quantity' => $quantity,
            ];
            $total += $produits->getPrixPlat() * $quantity;

        }
        $objectManager = $this->getDoctrine()->getManager();
//        $total = 0;
//
//        foreach($data as $item){
//            $totalitem = $produits->getPrixPlat() * $quantity;
//            $total += $totalitem;
//        }
//
//
//        $order = new Order();
//        $order->setClient($user);
//        $order->setTotal($total);
//       $order->setPanier(2);
//        $objectManager->persist($order);



        for ($i=0; $i < count($data); $i++) {
            $lignecommande = new Panier();
            // $lignecommande->setOrder($order);
            $lignecommande->setIdplat($data[$i]['product']);
            $lignecommande->setQuantite($data[$i]['quantity']);
            $lignecommande->setTotal($total);
            $lignecommande->setClient($userr);
            $objectManager->persist($lignecommande);
        }
        $objectManager->flush();
        $to = $this->getUser()->getUsername();
//        $to="marwa.memmi@esprit.tn";
        $email = (new Email())
            ->from('yummygout2@gmail.com')
            ->to($to)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html(' <div class="content">
 
            <h1 class="text-center" >Bonjour Mr,Mme</h1>
            <p class="block">
                Welcome to <strong>Yumy Gout</strong>
                Merci pour avoir commander des produits de chez nous.
               Pour annuler votre commande nous contacter sur +21528866995
            </p> <footer>
        Copyright &copy; <?php echo date("Y");?><strong><span>YummyGout Team</span></strong>. All Rights Reserved

    </footer>
        </div>')
        ;

        $mailer->send($email);
        return $this->redirectToRoute("order_index");
    }
    /**
     * @param PanierRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/panier/Affichefront2" , name="Affichefront2")
     */
    public function Affichefront2(PanierRepository $repository, PaginatorInterface $paginator,Request $request){
        $total= 0;
        $panier = new Panier();
        $userr=$this->getUser()->getUsername();
//        $userr="marwa.memmi@esprit.tn";
        $allpanier=$repository->findByclient($userr);
        $panierr = $paginator->paginate(

            $allpanier,
            $request->query->getInt('page', 1),
            3
        );
//        for ($i=0; $i < count($allpanier); $i++) {
        foreach ($allpanier as $value){
        $total += $panier->getTotal();}
        return $this->render('panier/Affichagefront.html.twig',['panierr'=>$panierr , 'total'=>$total]);

   }

    /**
     * @param MailerInterface $mailer
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendEmail(MailerInterface $mailer): void
   {
          $to = $this->getUser()->getUsername();
//        $to =  $userr="marwa.memmi@esprit.tn";
        $pdf=$this->showpdf();
//        $attachement = \Swift_Attachment::newInstance($pdf);
        $email = (new Email())
            ->from('yummygout2@gmail.com')
            ->to($to)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>')
        ->attach($pdf)
        ;

        $this->$mailer->send($email);



    }

    /**
     * @param PanierRepository $panierRepository
     * @Route("/listA", name="listA", methods={"GET"})
     * @return Response
     *
     */
public function showpdf(PanierRepository $panierRepository):Response
{
    $userr = $this->getUser()->getUsername();
//    $userr="marwa.memmi@esprit.tn";
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
//    $pdfOptions->setIsRemoteEnabled(true);
    $png = file_get_contents("logg.png");
    $pngbase64 = base64_encode($png);
    $dompdf = new Dompdf($pdfOptions);
    $panierRepository = $panierRepository->findByclient($userr);
    $html = $this->renderView('order/listA.html.twig', [
        'panierr' => $panierRepository, 'userr' => $userr, "img64" => $pngbase64
    ]);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("mypdf.pdf", [
        "Attachment" => true
    ]);
}

}