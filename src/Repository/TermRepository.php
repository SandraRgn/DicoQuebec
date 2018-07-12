<?php

namespace App\Repository;

use App\Entity\Term;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Term|null find($id, $lockMode = null, $lockVersion = null)
 * @method Term|null findOneBy(array $criteria, array $orderBy = null)
 * @method Term[]    findAll()
 * @method Term[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TermRepository extends ServiceEntityRepository
{

    public function findHomeTerms($keyword = null, $categorie = null){


        //QUERY BUILDER
        $qb = $this->createQueryBuilder("t");
        if($keyword){
            $qb->andWhere("t.term LIKE :kw");
            $qb->setParameter("kw", "%$keyword%");
        }

        $qb->orderBy("t.createdDate", "DESC");
        $query = $qb->getQuery();
        //pour limiter le nombre de résultats qu'on récupère
        $query->setMaxResults(50);
        $terms = $query->getResult();


        return $terms;
    }

    public function findTermsCategorie($categorie){


        //QUERY BUILDER
        $qb = $this->createQueryBuilder("t");

        if($categorie){
            $qb->andWhere("t.categorie = :ca");
            $qb->setParameter("ca", "$categorie");
        }
        $qb->orderBy("t.createdDate", "DESC");
        $query = $qb->getQuery();
        //pour limiter le nombre de résultats qu'on récupère
        $query->setMaxResults(50);
        $terms = $query->getResult();


        return $terms;
    }

    public function findTermLike(){


        //QUERY BUILDER
        $qb = $this->createQueryBuilder("t");
        $qb->orderBy("t.votesCount", "DESC");
        $query = $qb->getQuery();
        //pour limiter le nombre de résultats qu'on récupère
        $query->setMaxResults(50);
        $terms = $query->getResult();


        return $terms;
    }





    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Term::class);
    }

//    /**
//     * @return Term[] Returns an array of Term objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Term
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
