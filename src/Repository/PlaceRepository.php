<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    //creation d'une methode pour recuperer les mots cles
    public function searchCity(string $keyword){
        $querybuilder = $this->createQueryBuilder('p');
        $querybuilder->andWhere('p.nameCity LIKE :kw')->setParameter('kw','%'.$keyword.'%');
        $querybuilder->setMaxResults(40);
        return $querybuilder->getQuery()->getResult();
    }

//    public function findAllPlaceByCity($nameCity)
//    {
//        $qb = $this->createQueryBuilder('place');
//        $qb->where('place.nameCity = :nameCity')
//            ->setParameter('nameCity', $nameCity);
//
//        return $qb;
//    }


    // /**
    //  * @return Place[] Returns an array of Place objects
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
    public function findOneBySomeField($value): ?Place
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
