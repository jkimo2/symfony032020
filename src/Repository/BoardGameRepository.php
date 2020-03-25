<?php

namespace App\Repository;

use App\Entity\BoardGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BoardGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardGame[]    findAll()
 * @method BoardGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardGame::class);
    }

    /**
      * @return BoardGame[]
      */
    public function findWithCategories()
    {
        return $this->createQueryBuilder('b')  //select * from board_game déjà inclus
            ->leftJoin('b.categories', 'c')
            ->addSelect('c')
            ->orderBy('b.releasedAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return BoardGame[]
     */
    public function findWithCategories2()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT b, c FROM '.BoardGame::class.' b '      //SELECT b.* récupère un tableau  //SELECT b.id, b.name  récupère aussi un tableau
                 .'LEFT JOIN b.categories c '
                 .' ORDER BY b.releasedAt DESC '
            )
            ->setMaxResults(10)
            ->getResult();
    }
}
