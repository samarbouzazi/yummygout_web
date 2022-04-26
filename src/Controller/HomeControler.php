<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeControler extends AbstractController
{
    /**
     * @Route ("home", name ="homePage")
     */
    public function homePage():Response
    {
        $user= $this->getUser();

        return $this->render('pages/index.html.twig' , ['user' => $user]);

    }
}