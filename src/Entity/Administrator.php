<?php

namespace App\Entity;

use App\Repository\AdministratorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdministratorRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Administrator implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, ExpenseCategory>
     */
    #[ORM\OneToMany(targetEntity: ExpenseCategory::class, mappedBy: 'administrator')]
    private Collection $expenseCategories;

    #[ORM\ManyToOne(inversedBy: 'administrators')]
    private ?ExpensePaymentCategory $expensePaymentCategory = null;

    #[ORM\OneToOne(mappedBy: 'administrator', cascade: ['persist', 'remove'])]
    private ?AdministratorAccount $administratorAccount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, ExpensePaymentCategory>
     */
    #[ORM\OneToMany(targetEntity: ExpensePaymentCategory::class, mappedBy: 'administrator')]
    private Collection $expensePaymentCategories;

    public function __construct()
    {
        $this->expenseCategories = new ArrayCollection();
        $this->expensePaymentCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, ExpenseCategory>
     */
    public function getExpenseCategories(): Collection
    {
        return $this->expenseCategories;
    }

    public function addExpenseCategory(ExpenseCategory $expenseCategory): static
    {
        if (!$this->expenseCategories->contains($expenseCategory)) {
            $this->expenseCategories->add($expenseCategory);
            $expenseCategory->setAdministrator($this);
        }

        return $this;
    }

    public function removeExpenseCategory(ExpenseCategory $expenseCategory): static
    {
        if ($this->expenseCategories->removeElement($expenseCategory)) {
            // set the owning side to null (unless already changed)
            if ($expenseCategory->getAdministrator() === $this) {
                $expenseCategory->setAdministrator(null);
            }
        }

        return $this;
    }

    public function getExpensePaymentCategory(): ?ExpensePaymentCategory
    {
        return $this->expensePaymentCategory;
    }

    public function setExpensePaymentCategory(?ExpensePaymentCategory $expensePaymentCategory): static
    {
        $this->expensePaymentCategory = $expensePaymentCategory;

        return $this;
    }

    public function getAdministratorAccount(): ?AdministratorAccount
    {
        return $this->administratorAccount;
    }

    public function setAdministratorAccount(AdministratorAccount $administratorAccount): static
    {
        // set the owning side of the relation if necessary
        if ($administratorAccount->getAdministrator() !== $this) {
            $administratorAccount->setAdministrator($this);
        }

        $this->administratorAccount = $administratorAccount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, ExpensePaymentCategory>
     */
    public function getExpensePaymentCategories(): Collection
    {
        return $this->expensePaymentCategories;
    }

    public function addExpensePaymentCategory(ExpensePaymentCategory $expensePaymentCategory): static
    {
        if (!$this->expensePaymentCategories->contains($expensePaymentCategory)) {
            $this->expensePaymentCategories->add($expensePaymentCategory);
            $expensePaymentCategory->setAdministrator($this);
        }

        return $this;
    }

    public function removeExpensePaymentCategory(ExpensePaymentCategory $expensePaymentCategory): static
    {
        if ($this->expensePaymentCategories->removeElement($expensePaymentCategory)) {
            // set the owning side to null (unless already changed)
            if ($expensePaymentCategory->getAdministrator() === $this) {
                $expensePaymentCategory->setAdministrator(null);
            }
        }

        return $this;
    }
}
