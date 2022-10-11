<?php

namespace App\ReadModel\User\Filter;

use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\UchKak;
use App\Model\User\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Имя',
                'onchange' => 'this.form.submit()', // отправляет форму
            ]])
            ->add('email', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Email',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Ожидает' => User::STATUS_WAIT,
                'Активный' => User::STATUS_ACTIVE,
                'Блокированный' => User::STATUS_BLOCKED,
            ], 'required' => false, 'placeholder' => 'Статусы', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('role', Type\ChoiceType::class, ['choices' => [
                'Юзер' => Role::USER,
                'Админы' => Role::ADMIN,
            ], 'required' => false, 'placeholder' => 'Роли', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('uchkak', Type\ChoiceType::class, ['choices' => [
                'Матковод' => UchKak::MATKO,
                'Пчеловод' => UchKak::PCHEL,
                'ПчелоМатковод' => UchKak::PCHMAT,
                'Наблюдатель' => UchKak::NABLUD,
            ], 'required' => false, 'placeholder' => 'Участники', 'attr' => ['onchange' => 'this.form.submit()']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
