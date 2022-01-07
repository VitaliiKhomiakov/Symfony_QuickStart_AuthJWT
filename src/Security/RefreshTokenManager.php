<?php

namespace App\Security;

use App\Entity\RefreshTokensEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RefreshTokenManager extends \Gesdinet\JWTRefreshTokenBundle\Doctrine\RefreshTokenManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;


    /**
     * @param ObjectManager $om
     * @param $class
     * @param EntityManagerInterface $em
     */
    public function __construct(ObjectManager $om, $class, EntityManagerInterface $em)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
        $this->em = $em;
    }

    /**
     * @param RefreshTokenInterface $refreshToken
     * @param $andFlush
     * @return void
     */
    public function save(RefreshTokenInterface $refreshToken, $andFlush = true)
    {
        $refreshRepo = $this->em->getRepository(RefreshTokensEntity::class);
        $tokens = $refreshRepo->findBy(['username' => $refreshToken->getUsername()]);

        if (count($tokens) > 3) {
            $refreshRepo->removeUserTokens($refreshToken->getUsername());
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'An error has occurred please sign in again');
        }

        $this->objectManager->persist($refreshToken);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
}
