<?php
namespace AppBundle\Admin;

use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;

/**
 * Class PostAdmin
 *
 * @package AppBundle\Admin
 */
class PostAdmin extends Admin
{
    /**
     * Return the main admin form for this content.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        // Must return a fully qualified class name
        return 'AppBundle\Form\PostType';
    }

    /**
     * @return Datagrid
     */
    public function getDatagrid()
    {
        $datagrid = new Datagrid($this, array(
                'limit_per_page' => 10,
                'default_sort_column' => 'id',
                'default_sort_order' => 'asc',
            )
        );

        $datagrid
            ->addField(
                'id',
                'text',
                array(
                    'label' => '#',
                    'sortable' => true,
                )
            )
            ->addField(
                'image',
                'image',
                array(
                    'label' => 'Image',
                    'base_path' => 'uploads/posts'
                )
            )
            ->addField(
                'title',
                'text',
                array(
                    'label' => 'Title',
                    'sortable' => true,
                )
            )
            ->addField(
                'authorEmail',
                'text',
                array(
                    'label' => 'Author',
                    'sortable' => true,
                    'truncate' => 80,
                )
            )
            ->addField(
                'authorEmail',
                'link',
                array(
                    'label' => 'Email',
                    'label_link' => 'Email',
                    'mailto' => true,
                )
            )
            ->addField(
                'publishedAt',
                'date',
                array(
                    'label' => 'Published',
                    'sortable' => true,
                    'date_format' => 'd/m/Y',
                )
            )
            ->addField(
                'status',
                'boolean',
                array(
                    'label' => 'Published',
                    'sortable' => true,
                    'label_true' => 'Published',
                    'label_false' => 'Unpublished',
                )
            )
            ->addField(
                'callback',
                'text',
                array(
                    'label' => 'Comments',
                    'callback' => function ($entity) {
                        $comments = $entity->getComments();
                        return sizeof($comments);
                    },
                )
            );

        return $datagrid;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:Post';
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return 'AppBundle\Entity\Post';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return '{0} Posts|{1} Post|]1,Inf] Posts';
    }
}