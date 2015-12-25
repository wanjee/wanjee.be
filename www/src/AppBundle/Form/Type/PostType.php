<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PostType
 * @package AppBundle\Form
 */
class PostType extends AbstractType
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
                'summary',
                'textarea',
                array(
                    'help' => 'Short introduction.  Keep it simple and short.',
                    'group' => 'Content',
                )
            )
            ->add(
                'content',
                'textarea',
                array(
                    'attr' => array('rows' => 20),
                    'markdown' => true,
                    'group' => 'Content',
                )
            )
            ->add(
                'file',
                'file',
                array(
                    'label' => 'Image',
                    'required' => false,
                    'preview_base_path' => 'WebPath',
                    'group' => 'Media',
                )
            )
            ->add(
                'publishedAt',
                'datetime',
                array(
                    'widget' => 'choice',
                    'group' => 'Meta',
                )
            )
            ->add(
                'status',
                'checkbox',
                array(
                    'label' => 'Published',
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
                'data_class' => 'AppBundle\Entity\Post',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'post';
    }
}
