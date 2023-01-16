<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Add;


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
        foreach ($this->uchasties->activeGroupedList() as $item) {
            $uchasties[$item['group']][$item['name']] = $item['id'];
        }

        $builder
            ->add('uchastie', Type\ChoiceType::class, [
                'choices' => $uchasties,
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['sezon']);

    }
}
