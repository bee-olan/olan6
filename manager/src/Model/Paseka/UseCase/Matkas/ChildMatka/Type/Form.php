<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Type;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Type as ChildMatkaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', Type\ChoiceType::class, ['choices' => [
                // 'Эли' => ChildMatkaType::ELIT,
                // 'Бре' => ChildMatkaType::BREND,
                // 'Ада' => ChildMatkaType::ADAPT,
                'Мес' => ChildMatkaType::MESTN,
            ], 'attr' => ['onchange' => 'this.form.submit()']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }

    public function getBlockPrefix(): string
    {
        return 'type';
    }
}