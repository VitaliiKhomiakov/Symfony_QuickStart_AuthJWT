<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RefreshTokensRepository;

/**
 * RefreshTokens
 *
 * @ORM\Table(name="refresh_tokens")
 * @ORM\Entity(repositoryClass=RefreshTokensRepository::class)
 */
class RefreshTokensEntity
{
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="refresh_token", type="text", length=65535, nullable=false)
   */
  private $refreshToken;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="valid", type="datetime", nullable=false)
   */
  private $valid;

  /**
   * @var string
   *
   * @ORM\Column(name="username", type="string", length=100, nullable=false)
   */
  private $username;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getRefreshToken(): ?string
  {
    return $this->refreshToken;
  }

  public function setRefreshToken(string $refreshToken): self
  {
    $this->refreshToken = $refreshToken;

    return $this;
  }

  public function getValid(): ?\DateTimeInterface
  {
    return $this->valid;
  }

  public function setValid(\DateTimeInterface $valid): self
  {
    $this->valid = $valid;

    return $this;
  }

  public function getUsername(): ?string
  {
    return $this->username;
  }

  public function setUsername(string $username): self
  {
    $this->username = $username;

    return $this;
  }


}
