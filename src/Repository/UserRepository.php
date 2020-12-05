<?php

namespace App\Repository;

use App\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method UserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntity[]    findAll()
 * @method UserEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, UserEntity::class);
  }

/**
 * Used to upgrade (rehash) the user's password automatically over time.
 * @param UserInterface $user
 * @param string $newEncodedPassword
 * @throws ORMException
 * @throws OptimisticLockException
 */
  public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
  {
    if (!$user instanceof UserEntity) {
      throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
    }

    $user->setPassword($newEncodedPassword);
    $this->_em->persist($user);
    $this->_em->flush();
  }
}
