<?php

namespace App\Entity;

use App\Annotation\UserWebUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * WebUser
 *
 * @ORM\Table(name="web_user", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_1483a5e9e7927c74",
 *                             columns={"email"})})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Entity(repositoryClass="App\Repository\WebUserRepository")
 * @UniqueEntity("email")
 * @UserWebUser()
 */
class WebUser implements UserInterface
{
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="user_id_seq", allocationSize=1, initialValue=1)
     * @Groups({"read","read_list", "patch","single_user"})
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @Groups({"read","read_list", "write", "patch","role_set_list","single_user"})
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string|null
     * @Groups({"read","read_list", "write", "patch","role_set_list","single_user"})
     *
     * @ORM\Column(name="surname", type="string", length=45, nullable=true)
     * @Assert\NotBlank
     */
    private $surname;

    /**
     * @var string|null
     * @Groups({"read_list", "read", "role_set_list","single_user"})
     * @ORM\Column(name="concated_name", type="string", length=100, nullable=true)
     */
    private $concatedName;

    /**
     * @var string|null
     * @Groups({"read_list", "read", "role_set_list","single_user"})
     * @ORM\Column(name="receiver_account", type="string", length=100, nullable=false)
     */
    private $receiverAccount;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     * @Groups({"read","read_list", "write", "patch","single_user"})
     */
    private $isActive = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Groups({"read_list","single_user"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Groups({"read_list","single_user"})
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     * @Groups({"read","read_list", "write", "patch","single_user"})
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Groups({"write", "patch"})
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RoleSet", mappedBy="users")
     * @Groups({"read_list", "write", "patch","single_user"})
     *
     */
    private $roleSets;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", inversedBy="users")
     * @Groups({"read_list", "write", "patch","single_user"})
     *
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups({"read","read_list", "write", "patch","single_user"})
     */
    private $phone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $roleId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="user")
     */
    private $user;

    public function __construct()
    {
        $this->roleSets = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id= $id;

        return $this;
    }

    public function getConcatName(): ?string
    {
        return $this->concatedName;
    }

    public function setConcatedName(?string $name, ?string $surname): self
    {
        $this->concatedName = $name.' '.$surname;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getReceiverAccount(): ?string
    {
        return $this->receiverAccount;
    }

    public function setReceiverAccount(?string $name): self
    {
        $this->receiverAccount = $name;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addRoleSet(RoleSet $roleSet): self
    {
        if (!$this->roleSets->contains($roleSet)) {
            $this->roleSets[] = $roleSet;
            $roleSet->addUser($this);
        }

        return $this;
    }

    public function removeRoleSet(RoleSet $roleSet): self
    {
        if ($this->roleSets->contains($roleSet)) {
            $this->roleSets->removeElement($roleSet);
            $roleSet->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->getRolesAsCollection()->toArray();
    }

    /**
     * @return Collection
     */
    public function getRolesAsCollection(): Collection
    {
        $allRoles = new ArrayCollection();

        foreach ($this->getRoleSets() as $roleset) {
            foreach ($roleset->getRoles() as $rolesetRole) {
                $allRoles->add($rolesetRole);
            }
        }

        foreach ($this->roles as $role) {
            if (!$allRoles->exists(function ($key, $item) use ($role) {
                return $role->getRole() === $item->getRole();
            })) {
                $allRoles->add($role);
            }
        }

        return $allRoles;
    }

    /**
     * @return Collection|RoleSet[]
     */
    public function getRoleSets(): Collection
    {
        return $this->roleSets;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Transaction $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setUser($this);
        }

        return $this;
    }

    public function removeUser(Transaction $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUser() === $this) {
                $user->setUser(null);
            }
        }

        return $this;
    }
}
