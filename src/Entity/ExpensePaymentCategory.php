<?php

namespace App\Entity;

use App\Repository\ExpensePaymentCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpensePaymentCategoryRepository::class)]
class ExpensePaymentCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, ExpenseTransaction>
     */
    #[ORM\OneToMany(targetEntity: ExpenseTransaction::class, mappedBy: 'expensePaymentCategory')]
    private Collection $expenseTransactions;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Administrator>
     */
    #[ORM\OneToMany(targetEntity: Administrator::class, mappedBy: 'expensePaymentCategory')]
    private Collection $administrators;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'expensePaymentCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Administrator $administrator = null;

    public function __construct()
    {
        $this->expenseTransactions = new ArrayCollection();
        $this->administrators = new ArrayCollection();
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
            $expenseTransaction->setExpensePaymentCategory($this);
        }

        return $this;
    }

    public function removeExpenseTransaction(ExpenseTransaction $expenseTransaction): static
    {
        if ($this->expenseTransactions->removeElement($expenseTransaction)) {
            // set the owning side to null (unless already changed)
            if ($expenseTransaction->getExpensePaymentCategory() === $this) {
                $expenseTransaction->setExpensePaymentCategory(null);
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

    /**
     * @return Collection<int, Administrator>
     */
    public function getAdministrators(): Collection
    {
        return $this->administrators;
    }

    public function addAdministrator(Administrator $administrator): static
    {
        if (!$this->administrators->contains($administrator)) {
            $this->administrators->add($administrator);
            $administrator->setExpensePaymentCategory($this);
        }

        return $this;
    }

    public function removeAdministrator(Administrator $administrator): static
    {
        if ($this->administrators->removeElement($administrator)) {
            // set the owning side to null (unless already changed)
            if ($administrator->getExpensePaymentCategory() === $this) {
                $administrator->setExpensePaymentCategory(null);
            }
        }

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

    public function getAdministrator(): ?Administrator
    {
        return $this->administrator;
    }

    public function setAdministrator(?Administrator $administrator): static
    {
        $this->administrator = $administrator;

        return $this;
    }
}
