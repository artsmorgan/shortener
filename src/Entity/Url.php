<?php

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $short_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hits;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $added_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $redirect_url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->short_code;
    }

    public function setShortCode(string $short_code): self
    {
        $this->short_code = $short_code;

        return $this;
    }

    public function getHits(): ?string
    {
        return $this->hits;
    }

    public function setHits(?string $hits): self
    {
        $this->hits = $hits;

        return $this;
    }

    public function getAddedDate(): ?\DateTimeInterface
    {
        return $this->added_date;
    }

    public function setAddedDate(?\DateTimeInterface $added_date): self
    {
        $this->added_date = $added_date;

        return $this;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirect_url;
    }

    public function setRedirectUrl(string $redirect_url): self
    {
        $this->redirect_url = $redirect_url;

        return $this;
    }
}
