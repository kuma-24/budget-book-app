<?php

namespace App\Entity;

use App\Repository\ExpenseTransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpenseTransactionRepository::class)]
class ExpenseTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'expenseTransactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpenseCategory $expenseCategory = null;

    #[ORM\ManyToOne(inversedBy: 'expenseTransactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpensePaymentCategory $expensePaymentCategory = null;

    #[ORM\ManyToOne(inversedBy: 'expenseTransactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $payment_date = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpenseCategory(): ?ExpenseCategory
    {
        return $this->expenseCategory;
    }

    public function setExpenseCategory(?ExpenseCategory $expenseCategory): static
    {
        $this->expenseCategory = $expenseCategory;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeImmutable
    {
        return $this->payment_date;
    }

    public function setPaymentDate(\DateTimeImmutable $payment_date): static
    {
        $this->payment_date = $payment_date;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

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
}
