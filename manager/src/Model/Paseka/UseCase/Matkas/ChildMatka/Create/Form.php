<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;

use App\ReadModel\Paseka\Matkas\SparingFetcher;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Type as ChildMatkaType;;

use App\ReadModel\Paseka\Uchasties\GroupFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $sparings;
//    private $godaFetchers;

    public function __construct(SparingFetcher $sparings)
    {
        $this->sparings = $sparings;
//        $this->godaFetchers = $godaFetchers;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('name', Type\TextType::class)
            ->add('content', Type\TextareaType::class, [
                'label' => 'Описание ДочьМатки  ',
                'required' => false,
                'attr' => ['rows' => 3,
                'placeholder' => ' Подробное описание ДочьМатки'
                ]])
//              ->add('goda', Type\ChoiceType::class, [
//                'label' => 'Год выхода матки',
//                'choices' => array_flip($this->godaFetchers->assocGod()),
//                'expanded' => false,
//                'multiple' => false,
//            ])
            ->add('sparing', Type\ChoiceType::class, [
                'label' => 'Выбрать вид   облета  ',
                'choices' => array_flip($this->sparings->assoc()),
                'expanded' => true,
                'multiple' => false,
                ])
           // ->add('parent', Type\IntegerType::class, ['required' => false])
            ->add('plan_date', Type\DateType::class, [
                'label' => 'Дата выхода ДочьМатки  ',
                'required' => false, 
                'widget' => 'single_text', 
                'input' => 'datetime_immutable'
                ])
            // ->add('type', Type\ChoiceType::class, [
            //     'label' => 'В предстоящем сезоне планируете:   ',
            //     'choices' => [
            //     'Предложить маточек' => ChildMatkaType::AWTOR,
            //     'Предложить-Тестировать' => ChildMatkaType::AWTORTEST,
            //     'Тестировать маточек' => ChildMatkaType::TESTIR,
            //     'Пока наблюдаю' => ChildMatkaType::NABLUD,
            // ],
            //     'expanded' => true,
            //     'multiple' => false,
            // ])
            ->add('priority', Type\ChoiceType::class, [
                'label' => 'Приоритеты для заказа на тестирование   ',
                'choices' => [
                'Низкий' => 1,
                'Обычный' => 2,
                'Высокий' => 3,
                'Срочный' => 4
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