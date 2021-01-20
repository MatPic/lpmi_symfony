<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Traits\GetHost;

class CategoryController extends AbstractController
{
    use GetHost;
    public function detail(EntityManagerInterface $em, int $id) {
        $caterepo = $em->getRepository(Category::class);
        $produitrepo = $em->getRepository(Produit::class);
        $category = $caterepo->find($id);
        $products = $produitrepo->findByCategory($id);
        return $this->render("category/index.html.twig", ["category" => $category, "products" => $products, "host" => $this->getHost()]);
    }

    public function search(EntityManagerInterface $em, Request $req) {
        $produitrepo = $em->getRepository(Produit::class);
        $search = $req->query->get('search');
        $products = $produitrepo ->findByLibelleOrTexte($search);
        return $this->render("category/search.html.twig", ["search" => $search, "products" => $products, "host" => $this->getHost()]);
    }
}
