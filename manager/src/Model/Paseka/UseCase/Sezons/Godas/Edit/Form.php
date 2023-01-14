<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('god', Type\IntegerType::class, array(
                'label' => 'Исправляем год',
                'attr' => [
                    'placeholder' => 'Введите год'
                ]
            ))
            ->add('sezon', Type\TextType::class, array(
                'label' => 'Сезон',
                'attr' => [
                    'placeholder' => 'Введите текст'
                ]
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}

