<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Panier;
use App\Entity\Platt;
use App\Repository\OrderRepository;
use App\Repository\PanierRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



/**
 * @Route("/order", name="order_")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="index")
     */
    public function index(SessionInterface $session, PlatRepository $productsRepository): Response
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
    public function valider(PlatRepository $produits, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $data = [];
        foreach($panier as $id => $quantity){
            $data[] = [
                'product' => $produits->find($id),
                'quantity' => $quantity
            ];
        }
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findAll();
        $orderDetail = $this->getDoctrine()
            ->getRepository(Panier::class)
            ->findAll();
        $objectManager = $this->getDoctrine()->getManager();
        $order = new Order();
        $objectManager->persist($order);
        for ($i=0; $i < count($data); $i++) {
            $orderDetail = new Panier();
            $orderDetail->setOrder($order);
            $orderDetail->setIdplat($data[$i]['product']);
            $q=$data[$i]['product']->getQuantite() ;
            $data[$i]['product']->setQPlat($q-$data[$i]['quantity']);
            $orderDetail->setQuantite($data[$i]['quantity']);
            $objectManager->persist($orderDetail);
        }
        $panier = $session->get('panier', []);
        $session->set('panier', $panier);
        $objectManager->flush();
        return $this->redirectToRoute("order_index");

    }
   }