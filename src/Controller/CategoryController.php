<?php


namespace App\Controller;

use App\Service\BoutiqueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Traits\GetHost;

class CategoryController extends AbstractController
{
    use GetHost;
    public function detail(BoutiqueService $boutique, int $id) {
        $category = $boutique->findCategorieById($id);
        $products = $boutique->findProduitsByCategorie($id);
        return $this->render("category/index.html.twig", ["category" => $category, "products" => $products, "host" => $this->getHost()]);
    }
}