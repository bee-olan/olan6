<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Assign;

use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\ReadModel\Paseka\Sezons\Tochkas\TochkaMatkas\TochkaMatkaFetcher;
use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class Form extends AbstractType
{
    private $childmatkas;
    private $tochkamatkas;

    public function __construct(ChildMatkaFetcher $childmatkas,
                                TochkaMatkaFetcher $tochkamatkas)
    {
        $this->childmatkas = $childmatkas;
        $this->tochkamatkas = $tochkamatkas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

//dd($options['uchastie_id']);
        $childmatkas = []; $tochmatkas = []; $chi=[]; $toch = [];

        foreach ($this->childmatkas->listZakazForTochka($options['uchastie_id']) as $item) {
            $childmatkas[$item['name']] = $item['id'];
            $chi[$item['id']]= $item['id'];
        }
//dd($childmatkas);
        foreach ($this->tochkamatkas->allOfTochMatkaGruppa($options['gruppa']) as $item) {
            $tochmatkas[$item['name']] = $item['childmatka_id'];
            $toch[$item['childmatka_id']]= $item['childmatka_id'];
        }
        $testMatkas = array_diff($chi,$toch);



        $builder
            ->add('childmatkas', Type\ChoiceType::class, [
                'label' => 'Выбор ТестМаток для данного точка:   ',
                'choices' => $testMatkas,
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['uchastie_id', 'gruppa']);
    }
}
//class Form extends AbstractType
//{
//    public function buildForm(FormBuilderInterface $builder, array $options): void
//    {
//        $builder
//            ->add('pobelka_date', Type\DateType::class, [
//                'label' => 'Побелка  ',
//                'required' => false,
//                'widget' => 'single_text',
//                'input' => 'datetime_immutable'
//            ])
//            ->add('start_date', Type\DateType::class, [
//                'label' => 'Начало взятка  ',
//                'required' => false,
//                'widget' => 'single_text',
//                'input' => 'datetime_immutable'
//            ])
//
//            ->add('end_date', Type\DateType::class, [
//                'label' => 'Завершение взятка  ',
//                'required' => false,
//                'widget' => 'single_text',
//                'input' => 'datetime_immutable'
//            ])
//
//            ->add('rasstojan', Type\ChoiceType::class, [
//                'label' => 'Расстояние до взятка   ',
//                'choices' => [
//                    'до  0.5 км' => 1,
//                    '0.5 - 1 км' => 2,
//                    '1 - 1.5 км' => 3,
//                    '1.5 - 2.5 км' => 4
//                ],
//                'expanded' => true,
//                'multiple' => false,
//            ]);
//    }
//
//
//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults(array(
//            'data_class' => Command::class,
//        ));
//    }
//}
