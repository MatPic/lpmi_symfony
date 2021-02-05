<?php
namespace App\Service;

use App\Entity\LigneCommande;
use App\Entity\Produit;
use App\Entity\Commande;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    public function panierToCommande(Commande $commande,  ObjectManager $entityManager) {
        if (empty($this->panier)) {
            throw new \Exception('Empty basket');
        }

        foreach ($this->panier as $idProduit => $data) {
            $ligneCommande = new LigneCommande();

            $ligneCommande->setIdCommande($commande);
            $ligneCommande->setIdArticle($data['entity']);
            $ligneCommande->setPrix($data['entity']->getPrix());
            $ligneCommande->setQuantite($data['nbr']);

            $entityManager->persist($ligneCommande);
            $commande->addLigneCommande($ligneCommande);
        }

        return $commande;
    }

    public function getContenu() {
        return $this->panier;
    }

    public function getTotalPrix() {
      $total = 0;
      foreach ($this->panier as $idProduit => $data) {
        $prix = $this->produitrepo->getPrixById($idProduit);
        $total += $prix * $data['nbr'];
      }

      return $total;
    }

    public function getNbProduits() {
        $nbrProduit = 0;
        foreach ($this->panier as $idProduit => $data) {
          $nbrProduit += $data['nbr'];
        }
        return $nbrProduit;

    }

    public function addProduit(Produit $produit, int $quantite = 1) {
        if (!empty($this->panier[$produit->getId()])) {
          $this->panier[$produit->getId()]['nbr']+=1;
        } else {
          $this->panier[$produit->getId()] = ['entity' => $produit, 'nbr' => $quantite];
        }
        $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }

    public function removeProduit(int $idProduit) {
      if (!empty($this->panier[$idProduit]) && $this->panier[$idProduit] > 1) {
        $this->panier[$idProduit]['nbr']-=1;
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
