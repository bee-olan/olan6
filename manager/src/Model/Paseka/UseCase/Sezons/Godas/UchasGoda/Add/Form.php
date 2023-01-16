<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Add;


use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('koltochek', Type\ChoiceType::class, [
                'label' => 'Кол-во точков   ',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4
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
//        $resolver->setRequired(['sezon']);

    }
}
