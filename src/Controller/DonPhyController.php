<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonPhyController extends AbstractController
{
    /**
     * @Route("/don/phy", name="don_phy")
     */
    public function index(): Response
    {
        return $this->render('don_phy/index.html.twig', [
            'controller_name' => 'DonPhyController',
        ]);
    }
}
