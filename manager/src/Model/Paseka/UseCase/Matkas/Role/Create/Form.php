<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Role\Create;

use App\Model\Paseka\Entity\Matkas\Role\Permission;
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
            ->add('permissions', Type\ChoiceType::class, [
                'label' => 'Разрешения',
                'choices' => array_combine(Permission::names(), Permission::names()),
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'translation_domain' => 'matka_permissions',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
