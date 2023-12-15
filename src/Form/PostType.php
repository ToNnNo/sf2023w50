<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options: [
                /*'label_html' => true,
                'label' => 'title <sup style="color: red">*</sup>',*/
                'label' => 'post.title.label',
                'help' =>  'post.title.help', //"Le titre ne doit pas avoir plus de 100 caractères"
            ])
            ->add('content', options: [
                'label' => 'post.content.label',
                'attr' => ['rows' => 8]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'required' => false
        ]);
    }
}
