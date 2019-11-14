<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProvidersRepository")
 */
class Providers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CurrencyInProvider", mappedBy="Provider")
     */
    private $Provider;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProviderMethod", inversedBy="providerMethod")
     */
    private $method;

    public function __construct()
    {
        $this->Provider = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|CurrencyInProvider[]
     */
    public function getProvider(): Collection
    {
        return $this->Provider;
    }

    public function addProvider(CurrencyInProvider $provider): self
    {
        if (!$this->Provider->contains($provider)) {
            $this->Provider[] = $provider;
            $provider->setProvider($this);
        }

        return $this;
    }

    public function removeProvider(CurrencyInProvider $provider): self
    {
        if ($this->Provider->contains($provider)) {
            $this->Provider->removeElement($provider);
            // set the owning side to null (unless already changed)
            if ($provider->getProvider() === $this) {
                $provider->setProvider(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getMethod(): ?ProviderMethod
    {
        return $this->method;
    }

    public function setMethod(?ProviderMethod $method): self
    {
        $this->method = $method;

        return $this;
    }
}
