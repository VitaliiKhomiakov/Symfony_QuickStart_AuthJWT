<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
   * @return JsonResponse
   */
  public function signUp(Request $request, UserPasswordEncoderInterface $encoder)
  {
    $password = $request->get('password');
    $email = $request->get('email');
    $user = new User();
    $user->setPassword($encoder->encodePassword($user, $password));
    $user->setEmail($email);
    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();
    return $this->json($user);
  }
}
