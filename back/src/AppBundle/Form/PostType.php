<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                    'help' => 'Short introduction.  Keep it simple and short.'
                )
            )
            ->add(
                'content',
                'textarea',
                array(
                    'attr' => array('rows' => 20),
                    'markdown' => true,
                )
            )
            ->add(
                'file',
                'file',
                array(
                    'label' => 'Image',
                    'required' => false,
                    'preview_base_path' => 'WebPath',
                )
            )
            ->add('authorEmail', 'email')
            ->add(
                'publishedAt',
                'datetime',
                array(
                    'widget' => 'choice',
                )
            )
            ->add(
                'status',
                'checkbox',
                array(
                    'label' => 'Published',
                    'required' => false,
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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