<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Godas\Wzatoks\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', Type\TextareaType::class, [
                'label' => 'Описание сезона  ',
                'required' => false,
                'attr' => ['rows' => 3,
                    'placeholder' => ' комментарий'
                ]])
            ->add('kolwz', Type\ChoiceType::class, [
                'label' => 'Кол-во взятков за сезон   ',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3
                ],
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}

