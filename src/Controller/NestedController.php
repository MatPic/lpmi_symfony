<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PanierService;

class NestedController extends AbstractController {

    public function panier(PanierService $panierService) {
        $quantite = $panierService->getNbProduits();
        return $this->render('fragment/panier.html.twig', ['quantite' => $quantite]);
    }
}