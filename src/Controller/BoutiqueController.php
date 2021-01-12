<?php


namespace App\Controller;

use App\Service\BoutiqueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Traits\GetHost;

class BoutiqueController extends AbstractController
{
    use GetHost;
    public function findAll(BoutiqueService $boutique) {
        $categories = $boutique->findAllCategories();
        return $this->render("boutique/index.html.twig", ["categories" => $categories ,"host" => $this->getHost()]);
    }
}