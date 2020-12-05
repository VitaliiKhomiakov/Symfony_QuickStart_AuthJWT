<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/core")
 */
class UserController extends AbstractController
{
  /**
   * @Route("/user", name="user", methods="GET")
   */
  public function index(): Response
  {
    return $this->json([
      'message' => 'Welcome to your new controller!',
      'path' => 'src/Controller/UserController.php',
    ]);
  }

  /**
   * @Route("/user", name="update", methods="PATCH")
   * @IsGranted("ROLE_ADMIN")
   */
  public function update(): Response
  {
    return $this->json([
      'message' => 'Update',
      'path' => 'src/Controller/UserController.php',
    ]);
  }
}
