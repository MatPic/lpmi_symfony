<?php
namespace App\Service;

use App\Entity\LigneCommande;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Usager;
use App\Repository\ProduitRepository;
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

    public function panierToCommande(Usager $usager, ProduitRepository $produitRepository): Commande {
        if (empty($this->panier)) {
            throw new \Exception('Empty basket');
        }

        $commande = $this->initCommande($usager);

        $realPanier = $this->getContenu($produitRepository);

        foreach ($realPanier as $idProduit => $data) {
            $ligneCommande = $this->initLigneCommande($data, $commande);

            $commande->addLigneCommande($ligneCommande);
        }

        return $commande;
    }

    private function initCommande(Usager $usager): Commande {
        $commande = new Commande();
        $commande->setStatut("EN COURS");
        $commande->setIdUsager($usager);
        $commande->setDateCommande(new \DateTime('now'));

        return $commande;
    }

    private function initLigneCommande(array $data, Commande $commande): LigneCommande {
        $ligneCommande = new LigneCommande();
        $ligneCommande->setIdCommande($commande);
        $ligneCommande->setIdArticle($data['entity']);
        $ligneCommande->setPrix($data['entity']->getPrix());
        $ligneCommande->setQuantite($data['nbr']);

        return $ligneCommande;
    }

    public function getContenu(ProduitRepository $produitRepository): array {
        $realPanier = [];

        foreach ($this->panier as $k => $v) {
            $realPanier[$k] = [ 'entity' => $produitRepository->find($k), 'nbr' => $v ];
        }

        return $realPanier;
    }

    public function getTotalPrix() {
      $total = 0;
      foreach ($this->panier as $idProduit => $data) {
        $prix = $this->produitrepo->getPrixById($idProduit);
        $total += $prix * $data['nbr'];
      }

      return $total;
    }

    public function getNbProduits(): int {
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

        dump("in add PRoduit", $this->panier);
    }

    public function removeProduit(int $idProduit) {
      if (!empty($this->panier[$idProduit]) && $this->panier[$idProduit] > 1) {
        $this->panier[$idProduit]-=1;
      } else if(!empty($this->panier[$idProduit])) {
        $this->deleteProduit($idProduit);
      }
      $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }

    public function deleteProduit(int $idProduit) {
      unset($this->panier[$idProduit]);
      $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }

    public function clear() {
        $this->panier = array();
        $this->session->set(PanierService::$PANIER_SESSION, $this->panier);
    }
}
