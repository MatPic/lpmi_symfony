<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;

class BoutiqueController extends AbstractController
{
    public function findAll(EntityManagerInterface $em) {
        $caterepo = $em->getRepository(Category::class);
        $categories = $caterepo->findAll();
        dump($categories[0]->getLibelle());
        return $this->render("boutique/index.html.twig", ["categories" => $categories]);
    }
}
