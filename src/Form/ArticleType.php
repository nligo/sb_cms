<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('keyword')
            ->add('contents')
            ->add('pulic_at')
            ->add('is_show')
            ->add('created_at')
            ->add('updated_at')
            ->add('categories', EntityType::class, [
                'class'         => Category::class,
                'choice_label'  => function ($categories) {
                    return $categories->getName();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.is_public = true');
                },
                'required'      => false,
                'expanded'      => true,
                'multiple'      => true,
            ])

            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
