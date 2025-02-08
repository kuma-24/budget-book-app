<?php

namespace App\Form;

use App\Entity\ExpenseCategory;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseTransactionIndexSearchType extends AbstractType
{
    private $formOptions = [
        'expenseCategory' => [
            'class' => ExpenseCategory::class,
            'label' => '費目',
            'choice_label' => 'name',
            'placeholder' => '選択なし',
            'required' => false,
        ],
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentYear = date('Y');
        $years = range($currentYear - 2, $currentYear);
        $yearChoices = array_combine($years, $years);

        $currentMonth = date('m');
        $months = range(1, 12);
        $monthChoices = array_flip(array_combine(array_map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT), $months), $months));

        $builder
            ->add('year', ChoiceType::class, [
                'choices' => $yearChoices,
                'label' => '年',
                'placeholder' => '選択なし',
                'data' => $currentYear,
                'required' => false,
            ])
            ->add('month', ChoiceType::class, [
                'choices' => $monthChoices,
                'label' => '月',
                'placeholder' => '選択なし',
                'data' => $currentMonth,
                'required' => false,
            ])
            ->add('expenseCategory', EntityType::class, $this->formOptions['expenseCategory'])
            ->add('save', SubmitType::class)
            ->setAction('/expense_transaction/index')
            ->setMethod('post')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
