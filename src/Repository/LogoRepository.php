<?php

namespace OHMedia\LogoBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use OHMedia\LogoBundle\Entity\Logo;
use OHMedia\LogoBundle\Entity\LogoGroup;

/**
 * @method Logo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logo[]    findAll()
 * @method Logo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logo::class);
    }

    public function save(Logo $logo, bool $flush = false): void
    {
        $this->getEntityManager()->persist($logo);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Logo $logo, bool $flush = false): void
    {
        $this->getEntityManager()->remove($logo);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findNotInLogoGroup(LogoGroup $logoGroup)
    {
        $qb = $this->createQueryBuilder('l');

        if ($logoGroup->getId()) {
            $qb->where('l.id NOT IN (
                SELECT l2.id
                FROM '.Logo::class.' l2
                JOIN l2.groups g WITH g.id = :id
            )')
            ->setParameter('id', $logoGroup->getId());
        }

        return $qb->getQuery()
            ->getResult();
    }
}
