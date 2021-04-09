<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }


    // Affichage de la liste Campus(id)
    public function findByCampus($idCampus) {
        return $this->createQueryBuilder('idCampus')
            ->andWhere('idCampus.id = :val')
            ->setParameter('val', $idCampus)
            ->getQuery()
            ->getResult();
    }


    /**
     * Récupère les Events en lien avec la recherche
     * @return Event[]
     */
    public function findSearch(SearchData $searchData) : array
    {
        $query = $this
            ->createQueryBuilder('search')
            ->select('search', 'campus')
            ->join('search.campus', 'campus');

        if(!empty($searchData->textSearch)) {
            $query = $query
                ->andWhere('search.nameEvent LIKE :textSearch')
                ->setParameter('textSearch', "%{$searchData->textSearch}%");
        }

        if(!empty($searchData->campusSearch)) {
            $query = $query
                ->andWhere('search.campus IN (:campus)')
                ->setParameter('campus', $searchData->campusSearch);
        }

        if(!empty($searchData->statusSearch)) {
            $query = $query
                ->andWhere('search.status IN (:status)')
                ->setParameter('status', $searchData->statusSearch);
        }

        if(!empty($searchData->dateStartSearch)) {
            $query = $query
                ->andWhere('search.StartDateTime > (:dateStartSearch)')
                ->setParameter('dateStartSearch', ($searchData->dateStartSearch));
        }

        if(!empty($searchData->dateEndSearch)) {
            $query = $query
                ->andWhere('search.StartDateTime < (:dateEndSearch)')
                ->setParameter('dateEndSearch', ($searchData->dateEndSearch));
        }


        return $query->getQuery()->getResult();
    }
}
// /**
//  * @return Event[] Returns an array of Event objects
//  */
/*
public function findByExampleField($value)
{
    return $this->createQueryBuilder('s')
        ->andWhere('s.exampleField = :val')
        ->setParameter('val', $value)
        ->orderBy('s.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;
}
*/

/*
public function findOneBySomeField($value): ?Event
{
    return $this->createQueryBuilder('s')
        ->andWhere('s.exampleField = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult()
    ;
}
*/