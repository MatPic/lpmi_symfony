<?php
namespace App\Service;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;

class PanierService {
    static $PANIER_SESSION = 'panier';
    private $session;
    private $panier;
    private $produitrepo;

    public function __construct(SessionInterface $session, EntityManagerInterface $em) {
        $this->session = $session;
        $this->panier = $session->get(PanierService::$PANIER_SESSION, array());
        $this->produitrepo = $em->getRepository(Produit::class);
    }

    public function getContenu() {
        return $this->panier;
    }

    public function getTotalPrix() {
      $total = 0;
      foreach ($this->panier as $k => $v) {
        $prix = $this->produitrepo->getPrixById($k);
        $total += $prix * $v;
      }

      return $total;
    }

    public function getNbProduits() {
        $nbrProduit = 0;
        foreach ($this->panier as $k => $v) {
          $nbrProduit += $v;
        }
        return $nbrProduit;

    }

    public function addProduit(int $idProduit, int $quantite = 1) {
        if (!empty($this->panier[$idProduit])) {
          $this->panier[$idProduit]+=1;
        } else {
          $this->panier[$idProduit] = $quantite;
        }
        $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }

    public function removeProduit(int $idProduit) {
      if (!empty($this->panier[$idProduit]) && $this->panier[$idProduit] > 1) {
        $this->panier[$idProduit]-=1;
      } else if(!empty($this->panier[$idProduit])){
        $this->deleteProduit($idProduit);
      }
      $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }

    public function deleteProduit(int $idProduit) {
      dump($this->panier);
      unset($this->panier[$idProduit]);
      $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }

    public function clear() {
        $this->panier = array();
    }
}
