<?php

namespace App\Entity;

use App\Repository\UserHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserHistoryRepository::class)
 */
class UserHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtubeLinks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shortenedLinks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userHistory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYoutubeLinks(): ?string
    {
        return $this->youtubeLinks;
    }

    public function setYoutubeLinks(?string $youtubeLinks): self
    {
        $this->youtubeLinks = $youtubeLinks;

        return $this;
    }

    public function getShortenedLinks(): ?string
    {
        return $this->shortenedLinks;
    }

    public function setShortenedLinks(?string $shortenedLinks): self
    {
        $this->shortenedLinks = $shortenedLinks;

        return $this;
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
}
