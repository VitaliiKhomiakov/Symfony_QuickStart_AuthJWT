<?php

namespace App\Controller;

use App\Entity\UserEntity;
use App\Validators\AuthValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{

  /**
   * @Route("/sign-up", name="sign-up", methods="POST")
   * @param Request $request
   * @param UserPasswordEncoderInterface $encoder
   * @param AuthValidator $authValidator
   * @return JsonResponse
   */
  public function signUp(Request $request, UserPasswordEncoderInterface $encoder, AuthValidator $authValidator): JsonResponse
  {
    $password = $request->get('password', '');
    $confirmPassword = $request->get('confirmPassword', '');
    $email = $request->get('email', '');

    $error = $authValidator->signUpValidator([
      'password' => $password,
      'email' => $email,
      'confirmPassword' => $confirmPassword
    ]);

    if ($error) {
      return $this->json(['error' => $error->getMessage()], Response::HTTP_UNAUTHORIZED);
    }

    $em = $this->getDoctrine()->getManager();
    $userRepo = $em->getRepository(UserEntity::class);

    if ($userRepo->findBy(['email' => $email])) {
      return $this->json(['error' => 'This user already exist'], Response::HTTP_UNAUTHORIZED);
    }

    $user = new UserEntity();
    $user->setPassword($encoder->encodePassword($user, $password));
    $user->setEmail($email);

    $em->persist($user);
    $em->flush();

    return $this->json([
      'id' => $user->getId(),
      'email' => $user->getEmail(),
      'roles' => $user->getRoles()
    ], Response::HTTP_CREATED);
  }
}
