<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;

use App\ReadModel\Paseka\Matkas\PlemMatka\PlemMatkaFetcher;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $plemmatkas;

    public function __construct(PlemMatkaFetcher $plemmatkas)
    {
        $this->plemmatkas = $plemmatkas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('project', Type\ChoiceType::class, [
                'choices' => array_flip($this->plemmatkas->allList()),
            ])
            ->add('withChildren', Type\CheckboxType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
