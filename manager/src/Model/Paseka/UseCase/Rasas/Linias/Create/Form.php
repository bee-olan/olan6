<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Create;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', Type\TextType::class, array(
            'label' => 'Сокращенное название линии',
            'attr' => [
                'placeholder' => 'Введите сокр. название'
            ]
        ))
        ->add('nameStar', Type\TextType::class, array(
            'label' => 'Название линии в докуентах',
            'attr' => [
                'placeholder' => 'Введите название'
            ]
        ))
		->add('sortLinia', Type\IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
