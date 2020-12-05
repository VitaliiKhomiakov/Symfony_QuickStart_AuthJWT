<?php

namespace App\Repository;

use App\Entity\RefreshTokensEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RefreshTokensRepository extends ServiceEntityRepository {

  /**
   * RefreshTokensRepository constructor.
   * @param ManagerRegistry $registry
   */
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, RefreshTokensEntity::class);
  }

  /**
   * @param string $email
   * @return int|mixed|string
   */
  public function removeUserTokens(string $email) {
    return $this->createQueryBuilder('r')
      ->where('r.username = :email')
      ->setParameter('email', $email)
      ->delete()
      ->getQuery()
      ->execute();
  }
}
