<?php

namespace App\Entity;

use App\Repository\UrlShortenerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlShortenerRepository::class)
 */
class UrlShortener
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="urlShorteners")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_short;

    /**
     * @ORM\Column(type="string", length=1100, nullable=true)
     */
    private $url_long;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUrlShort(): ?string
    {
        return $this->url_short;
    }

    public function setUrlShort(string $url_short): self
    {
        $this->url_short = $url_short;

        return $this;
    }

    public function getUrlLong(): ?string
    {
        return $this->url_long;
    }

    public function setUrlLong(string $url_long): self
    {
        $this->url_long = $url_long;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
