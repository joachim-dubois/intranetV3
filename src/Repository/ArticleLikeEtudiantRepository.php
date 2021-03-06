<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\ArticleLikeEtudiant;
use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleLikeEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleLikeEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleLikeEtudiant[]    findAll()
 * @method ArticleLikeEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleLikeEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleLikeEtudiant::class);
    }

    public function findLike(Etudiant $etudiant, Article $article)
    {
        return $this->createQueryBuilder('a')
            ->where('a.etudiant = :etudiant')
            ->andWhere('a.article = :article')
            ->setParameter('etudiant', $etudiant->getId())
            ->setParameter('article', $article->getId())
            ->getQuery()
            ->getResult();
    }
}
