<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class Errors implements NormalizerInterface
{
  public function normalize($exception, string $format = null, array $context = [])
  {
    return [
      'exception'=> [
        'message' => $exception->getMessage(),
        'code' => $exception->getStatusCode(),
        'trace' => $exception->getTrace()
      ],
    ];
  }

  public function supportsNormalization($data, string $format = null)
  {
    return $data instanceof FlattenException;
  }
}
