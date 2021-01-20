<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Traits\GetHost;

class BoutiqueController extends AbstractController
{
    use GetHost;
    public function findAll(EntityManagerInterface $em) {
        $caterepo = $em->getRepository(Category::class);
        $categories = $caterepo->findAll();
        return $this->render("boutique/index.html.twig", ["categories" => $categories ,"host" => $this->getHost()]);
    }
}
