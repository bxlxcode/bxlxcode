<?php

namespace App\Repository;

use App\Entity\LanguageSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LanguageSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method LanguageSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method LanguageSource[]    findAll()
 * @method LanguageSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageSourceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LanguageSource::class);
    }

    // /**
    //  * @return LanguageSource[] Returns an array of LanguageSource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LanguageSource
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
