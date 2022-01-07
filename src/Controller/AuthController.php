<?php

namespace App\Controller;

use App\Service\UserService;
use App\Validators\AuthValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/sign-up", name="sign-up", methods="POST")
     * @param Request $request
     * @param AuthValidator $authValidator
     * @return JsonResponse
     */
    public function signUp(Request $request, AuthValidator $authValidator): JsonResponse
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

        if ($this->userService->isUserExist($email)) {
            return $this->json(['error' => 'This user already exist'], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->userService->createUser($email, $password);

        return $this->json([
          'id' => $user->getId(),
          'email' => $user->getEmail(),
          'roles' => $user->getRoles()
        ], Response::HTTP_CREATED);
    }
}
