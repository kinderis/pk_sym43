<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation AS JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TwoFactorRepository")
 */
class TwoFactor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     */
    private $twoFactorCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @JMS\Expose()
     */
    private $returnedCode;

    /**
     * @ORM\Column(type="datetime")
     * @JMS\Expose()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @JMS\Expose()
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transaction", inversedBy="transaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTwoFactorCode(): ?int
    {
        return $this->twoFactorCode;
    }

    public function setTwoFactorCode(int $twoFactorCode): self
    {
        $this->twoFactorCode = $twoFactorCode;

        return $this;
    }

    public function getReturnedCode(): ?int
    {
        return $this->returnedCode;
    }

    public function setReturnedCode(?int $returnedCode): self
    {
        $this->returnedCode = $returnedCode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }
}
