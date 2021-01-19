<?php


namespace App\Controller;

use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public static $TEMPLATE = "panier/index.html.twig";

    public function index(PanierService $pS) {
        dump($this->getPanier($pS));
        return $this->render(PanierController::$TEMPLATE, [ "panier" => $this->getPanier($pS)]);
    }

    public function add(int $idProduit, PanierService $pS) {
        $pS->addProduit($idProduit);
        return $this->redirectToRoute('panier.index');
    }

    public function remove(int $idProduit) {
        $pS->removeProduit($idProduit);
        return $this->render(PanierController::$TEMPLATE, [ "panier" => $this->getPanier($pS)]);
    }

    public function delete(int $idProduit) {
        $pS->deleteProduit($idProduit);
        return $this->render(PanierController::$TEMPLATE, [ "panier" => $this->getPanier($pS)]);
    }

    private function getPanier(PanierService $pS) {
        $panier = $pS->getContenu();
        dump($panier);
        return $panier;
    }
}
