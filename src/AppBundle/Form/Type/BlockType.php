<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BlockType
 * @package AppBundle\Form
 */
class BlockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add(
                'content',
                TextareaType::class,
                array(
                    'attr' => array('rows' => 20),
                    'markdown' => true,
                    'group' => 'Content',
                )
            )
            ->add(
                'image',
                FileType::class,
                array(
                    'label' => 'Image',
                    'required' => false,
                    'data_class' => null,
                    'preview_base_path' => 'image',
                    'group' => 'Media',
                )
            )
            ->add(
                'caption',
                TextType::class,
                array(
                    'label' => 'Caption',
                    'help' => 'Small description of the image.',
                    'group' => 'Media',
                    'required' => false,
                )
            )
            ->add(
                'weight',
                ChoiceType::class,
                array(
                    'label' => 'Weight',
                    'choices' => range(-20, 20),
                    'required' => true,
                    'help' => 'Relative position of this block amongst other.  Lower weight will "float" above the others.',
                    'group' => 'Meta',
                    // Must be set to true in > 2.7.  See http://symfony.com/doc/current/reference/forms/types/choice.html#choices-as-values
                    'choices_as_values' => true,
                )
            )
            ->add(
                'status',
                CheckboxType::class,
                array(
                    'label' => 'Published',
                    'required' => false,
                    'group' => 'Meta',
                )
            )
            ->add(
                'promoted',
                CheckboxType::class,
                array(
                    'label' => 'Promoted',
                    'required' => false,
                    'group' => 'Meta',
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Block',
            )
        );
    }
}
