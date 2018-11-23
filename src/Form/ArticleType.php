<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
            ->add('title',TextType::class,[
                'label' => 'article.title',
            ])
            ->add('keyword',TextType::class,[
                'label' => 'article.keyword',
            ])
            ->add('contents',CKEditorType::class,[
                'label' => 'article.contents',
                'config' => ['my_config'],
                'attr' => ['class' => 'tui-editor'],
            ])
            ->add('pulic_at',DateTimeType::class,[
                'label' => 'article.pulic_at',
            ])
            ->add('is_show',CheckboxType::class,[
                'label' => 'article.is_show',
                'attr' => ['class' => 'checkbox']
            ])
            ->add('created_at',DateTimeType::class,[
                'label' => 'article.created_at',
            ])
            ->add('updated_at',DateTimeType::class,[
                'label' => 'article.updated_at',
            ])
            ->add('categories', EntityType::class, [
                'label' => 'article.categories',
                'attr' => array('multiple' => 'multiple'),
                'class'         => Category::class,
                'choice_label'  => function ($categories) {
                    return $categories->getName();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.is_public = true');
                },
                'multiple'      => true,
            ])

            ->add('save',SubmitType::class,[
                'label' => 'article.save',
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    function CloseTags($html) {
        // 直接过滤错误的标签 <[^>]的含义是 匹配只有<而没有>的标签
        // 而preg_replace会把匹配到的用''进行替换
        $html = preg_replace('/<[^>]*$/','',$html);

        // 匹配开始标签，这里添加了1-6，是为了匹配h1~h6标签
        preg_match_all('#<([a-z1-6]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $opentags = $result[1];
        // 匹配结束标签
        preg_match_all('#</([a-z1-6]+)>#iU', $html, $result);
        $closetags = $result[1];
        $len_opened = count($opentags);
        // 如何两种标签数目一致 说明截取正好
        if (count($closetags) == $len_opened) { return $html; }

        $opentags = array_reverse($opentags);
        // 过滤自闭和标签，也可以在正则中过滤 <(?!meta|img|br|hr|input)>
        $sc = array('br','input','img','hr','meta','link');

        for ($i=0; $i < $len_opened; $i++) {
            $ot = strtolower($opentags[$i]);
            if (!in_array($opentags[$i], $closetags) && !in_array($ot,$sc)) {
                $html .= '</'.$opentags[$i].'>';
            } else {
                unset($closetags[array_search($opentags[$i], $closetags)]);
            }
        }
        return $html;
    }
}
