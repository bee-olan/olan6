<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Create;

use App\ReadModel\Paseka\Rasas\Linias\Nomers\SparingFetcher;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class Form extends AbstractType
{

    private $sparings;

    public function __construct(SparingFetcher $sparings)
    {
        $this->sparings = $sparings;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sparing', Type\ChoiceType::class, ['choices' => array_flip($this->sparings->assoc())])
            ->add('name', Type\TextType::class)
            ->add('nameStar', Type\TextType::class)
            ->add('sortNomer', Type\IntegerType::class);
            // ->add('title', Type\TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
