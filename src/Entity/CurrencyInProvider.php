<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyInProviderRepository")
 */
class CurrencyInProvider
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Currency", inversedBy="Currency")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Currency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Providers", inversedBy="Provider")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Provider;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?Currency
    {
        return $this->Currency;
    }

    public function setCurrency(?Currency $Currency): self
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getProvider(): ?Providers
    {
        return $this->Provider;
    }

    public function setProvider(?Providers $Provider): self
    {
        $this->Provider = $Provider;

        return $this;
    }
}
