<?php


namespace App\Controller;

use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public static $TEMPLATE = "panier/index.html.twig";

    public function index(PanierService $pS) {
        dump($pS->getTotalPrix());
        return $this->render(PanierController::$TEMPLATE, [ "panier" => $this->getPanier($pS)]);
    }

    public function add(int $idProduit, PanierService $pS) {
        dump("Add called");
        $pS->addProduit($idProduit);
        return $this->redirectToRoute('panier.index');
    }

    public function remove(int $idProduit, PanierService $pS) {
        dump("Remove called");
        $pS->removeProduit($idProduit);
        return $this->redirectToRoute('panier.index');
    }

    public function delete(int $idProduit, PanierService $pS) {
        dump("Delete called");
        $pS->deleteProduit($idProduit);
        return $this->redirectToRoute('panier.index');
    }

    private function getPanier(PanierService $pS) {
        return $pS->getContenu();
    }
}
