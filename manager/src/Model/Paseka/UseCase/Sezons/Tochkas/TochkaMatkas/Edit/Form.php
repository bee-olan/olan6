<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pobelka_date', Type\DateType::class, [
                'label' => 'Побелка  ',
                'required' => false,
                'widget' => 'single_text',
                'input' => 'datetime_immutable'
            ])
            ->add('start_date', Type\DateType::class, [
                'label' => 'Начало взятка  ',
                'required' => false,
                'widget' => 'single_text',
                'input' => 'datetime_immutable'
            ])

            ->add('end_date', Type\DateType::class, [
                'label' => 'Завершение взятка  ',
                'required' => false,
                'widget' => 'single_text',
                'input' => 'datetime_immutable'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}

