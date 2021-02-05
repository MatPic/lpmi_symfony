<?php


namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Usager;
use App\Service\PanierService;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public static $TEMPLATE = "panier/index.html.twig";

    public function index(PanierService $pS, Security $security) {
        $user = $security->getUser();
        dump($user);
        dump($pS->getTotalPrix());
        return $this->render(PanierController::$TEMPLATE, [ "panier" => $this->getPanier($pS)]);
    }

    public function add(int $idProduit, PanierService $pS, EntityManagerInterface $em) {
        dump("Add called");
        $produitrepo = $em->getRepository(Produit::class);
        $produit = $produitrepo->find($idProduit);
        $pS->addProduit($produit);
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

    public function validation(Security $security, PanierService $pS, EntityManagerInterface $em) {
        // TODO doctrine think it's a new entity

        $user = $security->getUser();
        if (empty($user)) {
            return $this->redirectToRoute('app_login');
        }
        $usager = $user;
        $commande = new Commande();
        $commande->setStatut("EN COURS");
        $commande->setIdUsager($usager);
        $commande->setDateCommande(new \DateTime('now'));

        try {
            $entityManager = $this->getDoctrine()->getManager();

            $commande = $pS->panierToCommande($commande, $entityManager);

            $entityManager->persist($commande);
            $entityManager->flush();

            $this->redirectToRoute('panier.index');
        } catch (\Exception $err) {
            throw $err;
            // TODO
        }


    }

    private function getPanier(PanierService $pS) {
        return $pS->getContenu();
    }
}
