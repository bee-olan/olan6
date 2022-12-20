<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;

use App\ReadModel\Paseka\Matkas\KategoriaFetcher;
//use App\ReadModel\Paseka\Matkas\SparingFetcher;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
//    private $sparings;
    private $kategorias;

    public function __construct(KategoriaFetcher $kategorias)
    {
//        $this->sparings = $sparings;
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
//            ->add('sparing', Type\ChoiceType::class, [
//                'label' => 'Вид облёта (спаринг)',
//                'choices' => array_flip($this->sparings->assoc()),
//                'expanded' => true,
//                'multiple' => false,
//            ])
            ->add('title', Type\TextType::class, array(
                'label' => ' Внутренняя нумерация или 
                 название маточки,  или комментарий',
                'attr' => [
                    'placeholder' => 'Пример: рыжая красотка )))'
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