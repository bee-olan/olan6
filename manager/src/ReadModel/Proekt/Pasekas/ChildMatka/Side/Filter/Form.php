<?php

namespace App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;

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
                'Даю маток' => ChildMatkaType::AWTOR,
                'Беру маток' => ChildMatkaType::TESTIR,
                'Наблюдаю' => ChildMatkaType::NABLUD,
                
            ], 'required' => false, 'placeholder' => 'Категории', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Новая' => Status::NEW,
                'Заказана' => Status::ZAKAZ ,
                'Тестируется' => Status::WORKING,
                'Вопрос' => Status::HELP,
                'Отклонена' => Status::REJECTED,
                'Тест завершено' => Status::DONE,
            ], 
            'required' => false,
            'expanded' => true,
            'multiple' => false, 
            'placeholder' => 'Статусы', 
            'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('priority', Type\ChoiceType::class, ['choices' => [
                'Низкий' => 1,
                'Обычный' => 2,
                'Высокий' => 3,
                'Срочный' => 4
            ], 'required' => false, 'placeholder' => 'Приоритеты', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('author', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false, 'placeholder' => 'матководу', 'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('executor', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false, 'placeholder' => 'Тестирующему', 'attr' => ['onchange' => 'this.form.submit()']
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
