<?php

namespace App\Repository;

use App\Entity\WebSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WebSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebSetting[]    findAll()
 * @method WebSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebSettingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WebSetting::class);
    }

    // /**
    //  * @return WebSetting[] Returns an array of WebSetting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WebSetting
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
