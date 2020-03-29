<?php

namespace App\Form;

use App\Entity\BoardGame;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('released_at',DateType::class,['html5' => true, 'widget' => 'single_text', 'attr' =>[
                'max' => date("today")
            ]])
            ->add('age_group',IntegerType::class,[
                'property_path' => 'ageGroup', 'attr' =>[
                'min' => 0,
            ]])
            ->add('categories', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])->add('toto', EntityType::class, [
                'class' => User::class,
                'property_path' => 'createur',
                'choice_label' => 'email'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoardGame::class,
            'label_format'=>'board_game.%name%.label'
        ]);
    }
}
