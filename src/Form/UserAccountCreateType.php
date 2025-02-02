<?php

namespace App\Form;

use App\Entity\UserAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAccountCreateType extends AbstractType
{
    private function setFormOption()
    {
        return [
            'first_name' => [
                'property_path' => 'first_name',
                'label' => '姓',
            ],
            'last_name' => [
                'property_path' => 'last_name',
                'label' => '名',
            ],
            'first_name_kana' => [
                'property_path' => 'first_name_kana',
                'label' => '姓カナ',
            ],
            'last_name_kana' => [
                'property_path' => 'last_name_kana',
                'label' => '名カナ',
            ],
            'birth_date' => [
                'property_path' => 'birth_date',
                'label' => '生年月日',
                'widget' => 'single_text',
            ],
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $formOptions = $this->setFormOption();

        $builder
            ->add('first_name', TextType::class, $formOptions['first_name'])
            ->add('last_name', TextType::class, $formOptions['last_name'])
            ->add('first_name_kana', TextType::class, $formOptions['first_name_kana'])
            ->add('last_name_kana', TextType::class, $formOptions['last_name_kana'])
            ->add('birth_date', null, $formOptions['birth_date'])
            ->add('save', SubmitType::class)
            ->setAction('/mypage/create')
            ->setMethod('post')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAccount::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
        ]);
    }
}
