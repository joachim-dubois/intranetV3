<?php

namespace App\Repository;

use App\Entity\QualiteQuestionnaireSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QualiteQuestionnaireSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method QualiteQuestionnaireSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method QualiteQuestionnaireSection[]    findAll()
 * @method QualiteQuestionnaireSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset =
 *         null)
 */
class QualiteQuestionnaireSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QualiteQuestionnaireSection::class);
    }

    // /**
    //  * @return QualiteQuestionnaireSection[] Returns an array of QualiteQuestionnaireSection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QualiteQuestionnaireSection
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}