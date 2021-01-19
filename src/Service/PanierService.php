<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
class PanierService {
    static $PANIER_SESSION = 'panier';
    private $session;
    private $boutique;
    private $panier;

    public function __construct(SessionInterface $session, BoutiqueService $boutique) {
        $this->boutique = $boutique;
        $this->session = $session;
        $this->panier = $session->get(PanierService::$PANIER_SESSION, array());
    }

    public function getContenu() {
        return $this->panier;
    }

    // public function getTotal() {
    //     // int $total;
    //     // foreach($this->panier as $k->$v) {

    //     // }
    // }

    public function getNbProduits() {
        return count($this->panier);
    }

    public function addProduit(int $idProduit, int $quantite = 1) {
        if (!empty($this->panier[$idProduit])) {
          $this->panier[$idProduit]+=1;
        } else {
          $this->panier[$idProduit] = $quantite;
        }
        $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }

    public function removeProduit(int $idProduit, int $quantite = 1) {
        // TODO
        var_dump($idProduit, $quantite);
    }

    public function deleteProduit(int $idProduit) {
        // $this->panier = \array_diff($this->panier, ["id" => $idProduit]); // Not sure
        var_dump($idProduit);
    }

    public function clear() {
        $this->panier = array();
    }
}
