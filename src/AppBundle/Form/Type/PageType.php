<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Page;
use AppBundle\Entity\Paragraph;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'required' => true,
                    'group' => 'Content',
                ]
            )
            ->add(
                'backgroundImage',
                FileType::class,
                [
                    'required' => true,
                    'data_class' => null,
                    'mapped' => true,
                    'group' => 'Content',
                    'preview_base_path' => 'backgroundImage',
                ]
            )
            ->add(
                'paragraphs',
                CollectionType::class,
                [
                    'entry_type' => ParagraphType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'allow_ordering' => true,
                    'by_reference' => false,
                    'group' => 'paragraph',
                ]
            )
            ->add(
                'status',
                CheckboxType::class,
                [
                    'label' => 'Published',
                    'required' => false,
                    'help' => 'Check this box so that this page is available, either using directly its URL or by using the menu item if provided.',
                    'group' => 'Meta',
                ]
            )
            ->add(
                'menuItem',
                CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'Add menu item',
                    'help' => 'Check this box to add this page in the footer menu.  Menu label is required if you check this.',
                    'group' => 'Meta',
                ]
            )
            ->add(
                'menuLabel',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Menu label',
                    'help' => 'Label is required if you enable the menu item.',
                    'group' => 'Meta',
                ]
            )
            ->add(
                'weight',
                ChoiceType::class,
                array(
                    'label' => 'Weight',
                    'choices' => range(0, 40),
                    'required' => true,
                    'help' => 'Relative position of this page in menu.  Lower weight will "float" above the others and will therefore be displayed first.',
                    'group' => 'Meta',
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // TODO: Should be better to use GroupSequenceProviderInterface to manage groups (http://symfony.com/doc/current/validation/sequence_provider.html)

        $resolver->setDefaults(array(
            'data_class' => Page::class,
            // Because Paragraph is an entity inside Page, we need to manage groups in Page.
            // Even if groups concern Paragraph.
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();

                $validationGroups = ['default'];

                if ($data->getMenuItem()) {
                    $validationGroups[] = 'menu_item_checked';
                }

                if ($data->getParagraphs()) {
                    foreach ($data->getParagraphs() as $paragraph) {

                        /** @var Paragraph $paragraph */
                        switch ($paragraph->getDisplayType()) {
                            case "intro_text":
                            case "text":
                                $validationGroups[] = 'body_required';
                                break;

                            case "image":
                                $validationGroups[] = 'image_required';
                                break;

                            case "text_image":
                            case "image_text":
                                $validationGroups[] = 'body_required';
                                $validationGroups[] = 'image_required';
                                break;
                        }
                    }
                }
                return $validationGroups;
            },
        ));
    }
}