<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor\Assign;

use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $uchasties;

    public function __construct(UchastieFetcher $uchasties)
    {
        $this->uchasties = $uchasties;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $uchasties = [];
        foreach ($this->uchasties->activeDepartmentListForPlemMatka($options['plemmatka_id']) as $item) {
//            $uchasties[$item['department'] . ' - ' . $item['name']] = $item['id'];
            $uchasties[$item['name']] = $item['id'];
        }
// dd($uchasties);
        $builder
            ->add('uchasties', Type\ChoiceType::class, [
                'label' => 'Назначьте исполнителя:   ',
                'choices' => $uchasties,
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['plemmatka_id']);
    }
}
