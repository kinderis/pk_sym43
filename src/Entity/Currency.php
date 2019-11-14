<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 */
class Currency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CurrencyInProvider", mappedBy="Currency")
     */
    private $Currency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="currency")
     */
    private $transactionCurrency;

    public function __construct()
    {
        $this->Provider = new ArrayCollection();
        $this->Currency = new ArrayCollection();
        $this->transactionCurrency = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|CurrencyInProvider[]
     */
    public function getCurrency(): Collection
    {
        return $this->Currency;
    }

    public function addCurrency(CurrencyInProvider $currency): self
    {
        if (!$this->Currency->contains($currency)) {
            $this->Currency[] = $currency;
            $currency->setCurrency($this);
        }

        return $this;
    }

    public function removeCurrency(CurrencyInProvider $currency): self
    {
        if ($this->Currency->contains($currency)) {
            $this->Currency->removeElement($currency);
            // set the owning side to null (unless already changed)
            if ($currency->getCurrency() === $this) {
                $currency->setCurrency(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionCurrency(): Collection
    {
        return $this->transactionCurrency;
    }

    public function addTransactionCurrency(Transaction $transactionCurrency): self
    {
        if (!$this->transactionCurrency->contains($transactionCurrency)) {
            $this->transactionCurrency[] = $transactionCurrency;
            $transactionCurrency->setCurrency($this);
        }

        return $this;
    }

    public function removeTransactionCurrency(Transaction $transactionCurrency): self
    {
        if ($this->transactionCurrency->contains($transactionCurrency)) {
            $this->transactionCurrency->removeElement($transactionCurrency);
            // set the owning side to null (unless already changed)
            if ($transactionCurrency->getCurrency() === $this) {
                $transactionCurrency->setCurrency(null);
            }
        }

        return $this;
    }

}
