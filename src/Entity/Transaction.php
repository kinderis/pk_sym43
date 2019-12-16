<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation AS JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WebUser", inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Expose()
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Expose()
     */
    private $details;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Expose()
     */
    private $receiverAccount;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Expose()
     */
    private $receiverName;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @JMS\Expose()
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Currency", inversedBy="transactionCurrency")
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Expose()
     */
    private $currency;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @JMS\Expose()
     */
    private $twoFactorCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @JMS\Expose()
     */
    private $accepted;

    /**
     * @ORM\Column(type="datetime")
     * @JMS\Expose()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Expose()
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @JMS\Expose()
     */
    private $transactionEnd;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     */
    private $transactionFee;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     * @JMS\Expose()
     */
    private $totalAmount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Expose()
     */
    private $providerResponse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TransactionStatus", inversedBy="status")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TwoFactor", mappedBy="transaction")
     */
    private $transaction;

    public function __construct()
    {
        $this->transaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?WebUser
    {
        return $this->user;
    }

    public function setUser(?WebUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getReceiverAccount(): ?string
    {
        return $this->receiverAccount;
    }

    public function setReceiverAccount(string $receiverAccount): self
    {
        $this->receiverAccount = $receiverAccount;

        return $this;
    }

    public function getReceiverName(): ?string
    {
        return $this->receiverName;
    }

    public function setReceiverName(string $receiverName): self
    {
        $this->receiverName = $receiverName;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTwoFactorCode(): ?int
    {
        return $this->twoFactorCode;
    }

    public function setTwoFactorCode(?int $twoFactorCode): self
    {
        $this->twoFactorCode = $twoFactorCode;

        return $this;
    }

    public function getAccepted(): ?int
    {
        return $this->accepted;
    }

    public function setAccepted(?int $accepted): self
    {
        $this->accepted = $accepted;

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

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTransactionEnd(): ?int
    {
        return $this->transactionEnd;
    }

    public function setTransactionEnd(?int $transactionEnd): self
    {
        $this->transactionEnd = $transactionEnd;

        return $this;
    }

    public function getTransactionFee(): ?int
    {
        return $this->transactionFee;
    }

    public function setTransactionFee(int $transactionFee): self
    {
        $this->transactionFee = $transactionFee;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getProviderResponse(): ?string
    {
        return $this->providerResponse;
    }

    public function setProviderResponse(?string $providerResponse): self
    {
        $this->providerResponse = $providerResponse;

        return $this;
    }

    public function getStatus(): ?TransactionStatus
    {
        return $this->status;
    }

    public function setStatus(?TransactionStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|TwoFactor[]
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function addTransactionId(TwoFactor $transaction): self
    {
        if (!$this->transaction->contains($transaction)) {
            $this->transaction[] = $transaction;
            $transaction->setTransaction($this);
        }

        return $this;
    }

    public function removeTransaction(TwoFactor $transaction): self
    {
        if ($this->transaction->contains($transaction)) {
            $this->transaction->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getTransaction() === $this) {
                $transaction->setTransaction(null);
            }
        }

        return $this;
    }
}
