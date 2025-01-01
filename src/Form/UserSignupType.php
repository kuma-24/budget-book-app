<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSignupType extends AbstractType
{
    private $formOptions = [
        'email' => [
            'label' => 'メールアドレス',
            'attr' => [
                'placeholder' => 'sample@email.com',
            ],
        ],
        'password' => [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'パスワード'
            ],
            'second_options' => [
                'label' => '確認用パスワード'
            ],
        ],
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, $this->formOptions['email'])
            ->add('password', RepeatedType::class, $this->formOptions['password'])
            ->add('save', SubmitType::class)
            ->setAction('/signup')
            ->setMethod('post')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
