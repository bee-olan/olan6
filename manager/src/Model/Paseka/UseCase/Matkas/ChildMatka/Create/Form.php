<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Type as ChildMatkaType;;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class)
            ->add('content', Type\TextareaType::class, ['required' => false, 'attr' => ['rows' => 10]])
            ->add('parent', Type\IntegerType::class, ['required' => false])
            ->add('plan', Type\DateType::class, ['required' => false, 'widget' => 'single_text', 'input' => 'datetime_immutable'])
            ->add('type', Type\ChoiceType::class, ['choices' => [
                'None' => ChildMatkaType::NONE,
                'Error' => ChildMatkaType::ERROR,
                'Свободна' => ChildMatkaType::SVOBODNA,
            ]])
            ->add('priority', Type\ChoiceType::class, ['choices' => [
                'Low' => 1,
                'Normal' => 2,
                'High' => 3,
                'Extra' => 4
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}