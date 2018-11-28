<?php

namespace App\Repository;

use App\Entity\PictureCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PictureCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictureCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictureCategory[]    findAll()
 * @method PictureCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PictureCategory::class);
    }

    // /**
    //  * @return PictureCategory[] Returns an array of PictureCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PictureCategory
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
