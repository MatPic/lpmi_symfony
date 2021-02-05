<?php


namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Usager;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public static $TEMPLATE = "panier/index.html.twig";
    public static $TEMPLATE_CONFIRM = "panier/command.html.twig";


    public function index(PanierService $pS, ProduitRepository $produitRepository) {
        dump($pS->getContenu($produitRepository));
        return $this->render(PanierController::$TEMPLATE, [ "panier" => $pS->getContenu($produitRepository)]);
    }

    public function add(int $idProduit, PanierService $pS, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $pS->addProduit($idProduit);
        return $this->redirectToRoute('panier.index');
    }

    public function remove(int $idProduit, PanierService $pS): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        dump("Remove called");
        $pS->removeProduit($idProduit);
        return $this->redirectToRoute('panier.index');
    }

    public function delete(int $idProduit, PanierService $pS): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        dump("Delete called");
        $pS->deleteProduit($idProduit);
        return $this->redirectToRoute('panier.index');
    }

    public function validation(Security $security, PanierService $pS, EntityManagerInterface $em, ProduitRepository $produitRepository): \Symfony\Component\HttpFoundation\Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usager = $security->getUser();

        // maybe persist and flush the command here
        try {
            $commande = $pS->panierToCommande($usager, $produitRepository);

            $entityManager->persist($commande);
            $entityManager->flush();

            $pS->clear();
        } catch (\Exception $err) {
            throw $err;
            // TODO
        }

        return $this->render(PanierController::$TEMPLATE_CONFIRM, [ "commande" => $commande]);
    }
}
