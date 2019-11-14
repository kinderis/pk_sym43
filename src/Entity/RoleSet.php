<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleSetRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class RoleSet
{
    use SoftDeleteableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read","role_set_list","role_set_single","single_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read", "write","read","role_list","role_set_list","read_list","role_set_single","single_user"})
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="WebUser")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read","role_set_list"})
     *
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="WebUser")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read","role_set_list"})
     */
    private $updatedBy;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", inversedBy="roleSets")
     * @Groups({"read", "write","role_set_list","role_set_single"})
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="WebUser", inversedBy="roleSets")
     */
    private $users;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Groups({"read", "write","read","role_list","role_set_list"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Groups({"read", "write","read","role_list","role_set_list"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedBy(): ?WebUser
    {
        return $this->createdBy;
    }

    public function setCreatedBy(WebUser $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?WebUser
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(WebUser $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    /**
     * @return Collection|WebUser[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(WebUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(WebUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

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
}
