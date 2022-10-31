<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Edit;


use App\ReadModel\Paseka\Matkas\SparingFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
//    private $sparings;
//
//    public function __construct(SparingFetcher $sparings)
//    {
//        $this->sparings = $sparings;
//
//    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
//            ->add('sparing', Type\ChoiceType::class, [
//                'label' => 'Вид облёта (спаринг)',
//                'choices' => array_flip($this->sparings->assoc())])
            ->add('title', Type\TextType::class, array(
                'label' => 'Ваша внутренняя нумерация или название маточки  и комментарий',
                'attr' => [
                    'placeholder' => 'Пример: рыжая красотка )))'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}