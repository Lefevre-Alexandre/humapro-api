<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return User
     * Vérifie si le token est bien attribuer à un utilisateur et retourne l'utilisateur.
     */
    public function findUserWithToken( $token )
    {
        $qb = $this->createQueryBuilder('u')
        ->where('u.access_token = :token')
        ->setParameter('token', $token);
        

        $query = $qb->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

    /**
     * @return User
     * Vérifie si l'utilisateur et bien un utilisateur enregistré et retourne l'utilisateur
     */
    public function checkUserAvailable( $email, $password )
    {
        $qb = $this->createQueryBuilder('u')
        ->where('u.email = :email', 'u.password = :password')
        ->setParameters( array('email'=> $email, 'password'=> $password) );
        

        $query = $qb->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

    /**
     * @return User
     * Vérifie si l'utilisateur et bien un utilisateur enregistré et que le token est bien rensigner et valide
     */
    public function checkUserAvailableAndTokenAvailable( $token )
    {
        $qb = $this->createQueryBuilder('u')
        ->where('u.access_token = :token')
        ->setParameter( 'token', $token );
        

        $query = $qb->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }


}
