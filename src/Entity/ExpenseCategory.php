<?php

namespace App\Entity;

use App\Repository\ExpenseCategoryRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpenseCategoryRepository::class)]
class ExpenseCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, ExpenseTransaction>
     */
    #[ORM\OneToMany(targetEntity: ExpenseTransaction::class, mappedBy: 'expenseCategory')]
    private Collection $expenseTransactions;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'expenseCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Administrator $administrator = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $budgetAmount = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
        $this->expenseTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ExpenseTransaction>
     */
    public function getExpenseTransactions(): Collection
    {
        return $this->expenseTransactions;
    }

    public function addExpenseTransaction(ExpenseTransaction $expenseTransaction): static
    {
        if (!$this->expenseTransactions->contains($expenseTransaction)) {
            $this->expenseTransactions->add($expenseTransaction);
            $expenseTransaction->setExpenseCategory($this);
        }

        return $this;
    }

    public function removeExpenseTransaction(ExpenseTransaction $expenseTransaction): static
    {
        if ($this->expenseTransactions->removeElement($expenseTransaction)) {
            // set the owning side to null (unless already changed)
            if ($expenseTransaction->getExpenseCategory() === $this) {
                $expenseTransaction->setExpenseCategory(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAdministrator(): ?Administrator
    {
        return $this->administrator;
    }

    public function setAdministrator(?Administrator $administrator): static
    {
        $this->administrator = $administrator;

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

    public function getBudgetAmount(): ?int
    {
        return $this->budgetAmount;
    }

    public function setBudgetAmount(?int $budgetAmount): static
    {
        $this->budgetAmount = $budgetAmount;

        return $this;
    }
}
