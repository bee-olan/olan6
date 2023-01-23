<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Assign;

use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class Form extends AbstractType
{
    private $childmatkas;
    private $uchasties;

    public function __construct(ChildMatkaFetcher $childmatkas, UchastieFetcher $uchasties)
    {
        $this->childmatkas = $childmatkas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

//dd($options['uchastie_id']);
        $childmatkas = [];
        foreach ($this->childmatkas->listZakazForTochka($options['uchastie']) as $item) {
//            $childmatkas[$item['department'] . ' - ' . $item['name']] = $item['id'];
            $childmatkas[$item['name']] = $item['id'];
        }
// dd($childmatkas);
        $builder
            ->add('childmatkas', Type\ChoiceType::class, [
                'label' => 'Назначьте исполнителя:   ',
                'choices' => $childmatkas,
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['uchastie']);
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
