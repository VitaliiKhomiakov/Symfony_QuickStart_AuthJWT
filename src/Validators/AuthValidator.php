<?php
namespace App\Validators;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AuthValidator {

  private $validator;
  public function __construct(ValidatorInterface $validator)
  {
    $this->validator = $validator;
  }

  /**
   * @param $params
   * @return ConstraintViolationInterface|null
   */
  public function signUpValidator($params): ?ConstraintViolationInterface
  {
    $signUpConstraint = new Assert\Collection([
      'confirmPassword' => new Assert\EqualTo(['value' => $params['password'], 'message' => 'Passwords do not match']),
      'password' => new Assert\Length(['min' => 6]),
      'email' => new Assert\Email()
    ]);

    $error = $this->validator->validate([
      'confirmPassword' => $params['confirmPassword'],
      'password' => $params['password'],
      'email' => $params['email']
    ], $signUpConstraint);

    return count($error) ? $error->get(0) : null;
  }
}
