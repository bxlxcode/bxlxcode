<?php

namespace App\Repository;

use App\Entity\LanguageAvailable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LanguageAvailable|null find($id, $lockMode = null, $lockVersion = null)
 * @method LanguageAvailable|null findOneBy(array $criteria, array $orderBy = null)
 * @method LanguageAvailable[]    findAll()
 * @method LanguageAvailable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageAvailableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LanguageAvailable::class);
    }

    // /**
    //  * @return LanguageAvailable[] Returns an array of LanguageAvailable objects
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
    public function findOneBySomeField($value): ?LanguageAvailable
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
