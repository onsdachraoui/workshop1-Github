<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Webmozart\Assert\Tests\StaticAnalysis\email;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    public function findByExampleField(): array
//    {
//        return $this->createQueryBuilder(alias:'a')
//            ->Where('a.username = :username')
//            ->AndWhere('a.email = :email')
//            ->setParameter('username','Laaa')
//            ->setParameter('email' ,'William.Shakespear@gmail.com')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//
//            ;
//    }


        // liste des livres
//    public function findbook($id): array
//    {
//        return $this->createQueryBuilder('a')
//            ->join('a.books','B')
//            ->addSelect('B')
//            ->where('B.author =:id')
//            ->setParameter('id', $id)
//            ->getQuery()
//            ->getResult()
//
//            ;
//    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function OrderEmail(){
        return $this->createQueryBuilder('A')
            ->orderBy('A.email','ASC')
            ->getQuery()
            ->getResult();
    }
}
