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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('keyword')
            ->add('contents',TextareaType::class,[
                'attr' => ['class' => 'form-control tui-editor'],
            ])
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
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $article = $event->getData();
                $request = Request::createFromGlobals();
                $contents = $request->request->get('tui-editor');
                if (!$article) {
                    return;
                }
                $article['contents'] = $contents;
                $event->setData($article);
            })
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
