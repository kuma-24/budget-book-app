<?php

namespace App\Form;

use App\Entity\ExpenseCategory;
use App\Entity\ExpensePaymentCategory;
use App\Entity\ExpenseTransaction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseTransactionEditType extends AbstractType
{
    private $formOptions = [
        'payment_date' => [
            'property_path' => 'payment_date',
            'label' => '決済日',
            'widget' => 'single_text',
        ],
        'amount' => [
            'property_path' => 'amount',
            'label' => '金額',
            'html5' => true,
        ],
        'note' => [
            'property_path' => 'note',
            'label' => 'メモ',
            'attr' => [
                'placeholder' => '用途など',
            ],
        ],
        'expenseCategory' => [
            'class' => ExpenseCategory::class,
            'label' => '費目種別',
            'choice_label' => 'name',
            'placeholder' => '選択してください',
            'required' => true,
        ],
        'expensePaymentCategory' => [
            'class' => ExpensePaymentCategory::class,
            'label' => '決済方法',
            'choice_label' => 'name',
            'placeholder' => '選択してください',
            'required' => true,
        ]
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('payment_date', null, $this->formOptions['payment_date'])
            ->add('amount', NumberType::class, $this->formOptions['amount'])
            ->add('note', TextType::class, $this->formOptions['note'])
            ->add('expenseCategory', EntityType::class, $this->formOptions['expenseCategory'])
            ->add('expensePaymentCategory', EntityType::class, $this->formOptions['expensePaymentCategory'])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExpenseTransaction::class,
        ]);
    }
}
