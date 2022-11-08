<?php

namespace App\ReadModel\Paseka\Matkas\ChildMatka\Filter;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Status;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Type as ChildMatkaType;
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
            ->add('text', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Search...',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('type', Type\ChoiceType::class, ['choices' => [
                'None' => ChildMatkaType::NONE,
                'Error' => ChildMatkaType::ERROR,
                'Свободна' => ChildMatkaType::SVOBODNA,
            ], 'required' => false, 'placeholder' => 'All types', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'новая' => Status::NEW,
                'в работе' => Status::WORKING,
                'вопрос' => Status::HELP,
                'отклонена' => Status::REJECTED,
                'завершино' => Status::DONE,
            ], 'required' => false, 'placeholder' => 'All statuses', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('priority', Type\ChoiceType::class, ['choices' => [
                'Low' => 1,
                'Normal' => 2,
                'High' => 3,
                'Extra' => 4
            ], 'required' => false, 'placeholder' => 'All priorities', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('author', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false, 'placeholder' => 'All authors', 'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('executor', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false, 'placeholder' => 'All executors', 'attr' => ['onchange' => 'this.form.submit()']
            ]);
    //         ->add('roots', Type\ChoiceType::class, ['choices' => [
    //             'Roots' => Status::NEW,
    //         ], 'required' => false, 'placeholder' => 'All levels', 'attr' => ['onchange' => 'this.form.submit()']]);
     }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
