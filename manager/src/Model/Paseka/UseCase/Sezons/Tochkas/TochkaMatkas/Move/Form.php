<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Move;

use App\ReadModel\Paseka\Sezons\Tochkas\TochkaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $tochkas;

    public function __construct(TochkaFetcher $tochkas)
    {
        $this->tochkas = $tochkas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tochka', Type\ChoiceType::class, [
                'choices' => array_flip($this->tochkas->allListTochka($options['uchasgoda_id'])),
            ]);
//            ->add('withChildren', Type\CheckboxType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['uchasgoda_id']);
    }
}

