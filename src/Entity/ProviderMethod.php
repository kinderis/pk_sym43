<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProviderMethodRepository")
 */
class ProviderMethod
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $method;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Providers", mappedBy="method")
     */
    private $providerMethod;

    public function __construct()
    {
        $this->providerMethod = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return Collection|Providers[]
     */
    public function getProviderMethod(): Collection
    {
        return $this->providerMethod;
    }

    public function addProviderMethod(Providers $providerMethod): self
    {
        if (!$this->providerMethod->contains($providerMethod)) {
            $this->providerMethod[] = $providerMethod;
            $providerMethod->setMethod($this);
        }

        return $this;
    }

    public function removeProviderMethod(Providers $providerMethod): self
    {
        if ($this->providerMethod->contains($providerMethod)) {
            $this->providerMethod->removeElement($providerMethod);
            // set the owning side to null (unless already changed)
            if ($providerMethod->getMethod() === $this) {
                $providerMethod->setMethod(null);
            }
        }

        return $this;
    }
}
