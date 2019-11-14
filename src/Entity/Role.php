<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role as BaseRole;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 */
class Role extends BaseRole
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="role_id_seq", allocationSize=1, initialValue=1)
     * @Groups({"read","role_list","role_set_list","role_set_single","single_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"read", "write","read","role_list","role_set_list","role_set_single","single_user"})
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"read","read","role_list","role_set_single","single_user"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RoleSet", mappedBy="roles")
     * @Groups({"read","read"})
     */

    private $roleSets;

    /**
     * @ORM\ManyToMany(targetEntity="WebUser", mappedBy="roles")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $hrdVlu;

    public function __construct()
    {
        $this->roleSets = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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

    /**
     * @return Collection|RoleSet[]
     */
    //public function getRoleSets(): Collection
    //{
    //    return $this->roleSets;
    //}

    public function addRoleSet(RoleSet $roleSet): self
    {
        if (!$this->roleSets->contains($roleSet)) {
            $this->roleSets[] = $roleSet;
            $roleSet->addRole($this);
        }

        return $this;
    }

    public function removeRoleSet(RoleSet $roleSet): self
    {
        if ($this->roleSets->contains($roleSet)) {
            $this->roleSets->removeElement($roleSet);
            $roleSet->removeRole($this);
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
            $user->addRole($this);
        }

        return $this;
    }

    public function removeUser(WebUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeRole($this);
        }

        return $this;
    }

    /**
     * @return Collection|RoleSet[]
     */
    public function getRoleSets(): Collection
    {
        return $this->roleSets;
    }

    public function getHrdVlu(): ?string
    {
        return $this->hrdVlu;
    }

    public function setHrdVlu(?string $hrdVlu): self
    {
        $this->hrdVlu = $hrdVlu;

        return $this;
    }
}
