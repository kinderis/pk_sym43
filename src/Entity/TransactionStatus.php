<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionStatusRepository")
 */
class TransactionStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="status")
     */
    private $status;

    /**
     * @ORM\Column(name="name", type="string", columnDefinition="enum('draft', 'approved')")
     */
    private $name;

    public function __construct()
    {
        $this->status = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getStatusId(): Collection
    {
        return $this->status;
    }

    public function addStatusId(Transaction $statusId): self
    {
        if (!$this->status->contains($statusId)) {
            $this->status[] = $statusId;
            $statusId->setStatusId($this);
        }

        return $this;
    }

    public function removeStatusId(Transaction $statusId): self
    {
        if ($this->status->contains($statusId)) {
            $this->status->removeElement($statusId);
            // set the owning side to null (unless already changed)
            if ($statusId->getStatusId() === $this) {
                $statusId->setStatusId(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
