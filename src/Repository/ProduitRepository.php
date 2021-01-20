<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */

    public function findByLibelleOrTexte($query)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.libelle LIKE :val OR p.texte LIKE :val')
            ->setParameter('val', "%{$query}%")
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCategory($val)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.idCategorie = :val')
            ->setParameter('val', $val)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getPrixById($id) {
      $result = $this->createQueryBuilder('p')
          ->andWhere('p.id = :id')
          ->setParameter(':id', $id)
          ->select('p.prix')
          ->getQuery()
          ->getResult()
      ;

      return $result[0]["prix"];
    }

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
