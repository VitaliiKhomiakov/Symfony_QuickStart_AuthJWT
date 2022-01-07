<?php

namespace App\Service;

use App\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {

    private EntityManagerInterface $entityManager;
    private ObjectRepository $userRepo;
    private UserPasswordEncoderInterface $encoder;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->userRepo = $this->entityManager->getRepository(UserEntity::class);
        $this->encoder = $encoder;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isUserExist(string $email): bool
    {
        return !!$this->getUserByEmail($email);
    }

    /**
     * @param string $email
     * @param string $password
     * @return UserEntity
     */
    public function createUser(string $email, string $password): UserEntity
    {
        $user = new UserEntity();
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setEmail($email);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param string $email
     * @return UserEntity
     */
    public function getUserByEmail(string $email): UserEntity
    {
        return $this->userRepo->findOneBy(['email' => $email]);
    }
}
