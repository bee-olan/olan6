<?php

namespace App\Model\Paseka\UseCase\Uchasties\Uchastie\UchKak;

use App\Model\Paseka\Entity\Uchasties\Uchastie\UchKak;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uchkak', Type\ChoiceType::class, ['label' => 'Участие как', 'choices' => [
                'Матковод' => UchKak::MATKO,
                'Пчеловод' => UchKak::PCHEL,
                'Пчеловод - Матковод' => UchKak::PCHMAT,
                'Наблюдатель' => UchKak::NABLUD,
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
