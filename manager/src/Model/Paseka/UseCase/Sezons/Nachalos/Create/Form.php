<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Nachalos\Create;

use App\Model\Paseka\Entity\Sezons\Godas\Goda;
use App\ReadModel\Paseka\Sezons\Godas\GodaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $godas;

    public function __construct(GodaFetcher $godas)
    {
        $this->godas = $godas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        dd(array_flip($this->godas->assoc()));
        $builder
            ->add('goda', Type\ChoiceType::class, [
                'label' => 'Выбрать год участия  ',
                'choices' => array_flip($this->godas->assoc()),
                'expanded' => true,
                'multiple' => false,

            ])
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
