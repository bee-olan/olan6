<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Create;

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

    public function buildForm( FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\ChoiceType::class, [
                'label' => 'Сезон работы матки',
                'choices' => array_flip($this->godas->assocGod()),
                'expanded' => true,
                'multiple' => false,
            ]);

//            ->add('name', Type\TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
