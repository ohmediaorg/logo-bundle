<?php

namespace OHMedia\LogoBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use OHMedia\LogoBundle\Entity\LogoGroup;

/**
 * @method LogoGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogoGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogoGroup[]    findAll()
 * @method LogoGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogoGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogoGroup::class);
    }

    public function save(LogoGroup $logoGroup, bool $flush = false): void
    {
        $this->getEntityManager()->persist($logoGroup);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LogoGroup $logoGroup, bool $flush = false): void
    {
        $this->getEntityManager()->remove($logoGroup);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
