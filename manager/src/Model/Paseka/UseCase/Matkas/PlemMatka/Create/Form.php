<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;

use App\ReadModel\Paseka\Matkas\KategoriaFetcher;
//use App\ReadModel\Paseka\Matkas\SparingFetcher;

use App\ReadModel\Paseka\Sezons\Godas\GodaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $godaFetchers;
    private $kategorias;

    public function __construct(KategoriaFetcher $kategorias, GodaFetcher $godaFetchers)
    {
        $this->godaFetchers = $godaFetchers;
        $this->kategorias = $kategorias;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dd($this->kategorias->assoc());
        $builder
            ->add('kategoria', Type\ChoiceType::class, [
                'label' => 'Категория ПлемМатки',
                'choices' => array_flip($this->kategorias->allList()),
                'expanded' => true,
                'multiple' => false
            ])
            ->add('goda', Type\ChoiceType::class, [
                'label' => 'Год выхода матки',
                'choices' => array_flip($this->godaFetchers->assocGod()),
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('title', Type\TextType::class, array(
                'label' => ' Внутренняя нумерация',
                'attr' => [
                    'placeholder' => 'Внутреняя нумрация или комментарий. Пример: рыжая красотка )))'
                ]
            ));
//            ->add('sort', Type\IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}