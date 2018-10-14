<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * Repository used to add custom queries for application event information.
 *
 * @author Florian Mornet <florian.mornet@enseirb-matmeca.fr>
 */
class EventRepository extends ServiceEntityRepository
{
    /**
     * EventRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @param User $user
     * @return Event[] Returns an array of Event objects
     */
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.poster = :val')
            ->setParameter('val', $user)
            ->orderBy('e.date_start', 'ASC')
            ->orderBy('e.time_start', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param User $user
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countEventsByUser(User $user)
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id)')
            ->andWhere('e.poster = :val')
            ->setParameter('val', $user)
            ->orderBy('e.date_start', 'ASC')
            ->orderBy('e.time_start', 'ASC')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
