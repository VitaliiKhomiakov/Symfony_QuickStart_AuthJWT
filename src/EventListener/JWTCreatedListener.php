<?php
namespace App\EventListener;
use App\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener {
  /**
   * @var RequestStack
   */
  private $requestStack;

  /**
   * @var
   */
  private $em;

  /**
   * @param RequestStack $requestStack
   * @param EntityManagerInterface $em
   */
  public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
  {
    $this->requestStack = $requestStack;
    $this->em = $em;
  }

  /**
   * @param JWTCreatedEvent $event
   * @return void
   */
  public function onJWTCreated(JWTCreatedEvent $event)
  {
    $userRepo = $this->em->getRepository(UserEntity::class);
    $user = $userRepo->findOneBy(['email' => $event->getUser()->getUsername()]);
    $event->setData([
      'id' => $user->getId(),
      // the username field is used to check JWT
      'username' => $user->getEmail(),
    ]);
  }
}
