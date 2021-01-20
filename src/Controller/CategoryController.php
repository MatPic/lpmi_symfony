<?php


namespace App\Controller;

use App\Service\BoutiqueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Traits\GetHost;

class CategoryController extends AbstractController
{
    use GetHost;
    public function detail(BoutiqueService $boutique, int $id) {
        $category = $boutique->findCategorieById($id);
        $products = $boutique->findProduitsByCategorie($id);
        return $this->render("category/index.html.twig", ["category" => $category, "products" => $products, "host" => $this->getHost()]);
    }

    public function search(BoutiqueService $boutique, Request $req) {
        $search = $req->query->get('search');
        $products = $boutique->findProduitsByLibelleOrTexte($search);
        return $this->render("category/search.html.twig", ["search" => $search, "products" => $products, "host" => $this->getHost()]);
    }
}
