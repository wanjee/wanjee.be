<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Paragraph;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParagraphType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(
                'displayType',
                ChoiceType::class,
                [
                    'choices' => [
                        'Intro text' => 'intro_text',
                        'Text' => 'text',
                        'Text and image' => 'text_image',
                        'Image and text' => 'image_text',
                        'Image' => 'image'
                    ],
                    'required' => true,
                ]
            )
            ->add(
                'image',
                FileType::class,
                [
                    'required' => false,
                    'data_class' => null,
                    'mapped' => true,
                    'preview_base_path' => 'image',
                ]
            )
            ->add(
                'body',
                TextareaType::class,
                [
                    'required' => false,
                    'markdown' => true,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Paragraph::class,
        ));
    }
}