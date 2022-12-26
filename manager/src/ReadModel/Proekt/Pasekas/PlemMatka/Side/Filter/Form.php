<?php

declare(strict_types=1);

namespace App\ReadModel\Proekt\Pasekas\PlemMatka\Side\Filter;


use App\Model\Paseka\Entity\Matkas\PlemMatka\Status;
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
                'placeholder' => 'Введите часть названия',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('name_kateg', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Введите название ',
                'onchange' => 'this.form.submit()', // отправляет форму
            ]])
            ->add('persona', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Поле для ввода номера',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Активные' => Status::ACTIVE,
                'В архиве' => Status::ARCHIVED,
            ], 
            'required' => false,
            'expanded' => true,
            'multiple' => false,
            'placeholder' => 'Все статусы', 
            'attr' => ['onchange' => 'this.form.submit()']]);
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
