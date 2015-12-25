<?php
namespace AppBundle\Admin;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;

/**
 * Class BlockAdmin
 *
 * @package AppBundle\Admin
 */
class BlockAdmin extends Admin
{
    private $router;

    /**
     *
     */
    function __construct(Router $router)
    {
        parent::__construct();
        $this->router = $router;
    }

    /**
     * Return the main admin form for this content.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        // Must return a fully qualified class name
        return 'AppBundle\Form\Type\BlockType';
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
                'promoted',
                'boolean',
                array(
                    'label' => 'Promoted',
                    'sortable' => true,
                )
            )
        ;

        return $datagrid;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return 'AppBundle\Entity\Block';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return '{0} Blocks|{1} Block|]1,Inf] Blocks';
    }
}
