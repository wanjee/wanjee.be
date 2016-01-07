<?php
namespace AppBundle\Admin;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;

/**
 * Class PostAdmin
 *
 * @package AppBundle\Admin
 */
class PostAdmin extends Admin
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
        return 'AppBundle\Form\Type\PostType';
    }

    /**
     * @return Datagrid
     */
    public function getDatagrid()
    {
        $datagrid = new Datagrid($this, array(
                'limit_per_page' => 15,
                'default_sort_column' => 'publishedAt',
                'default_sort_order' => 'desc',
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
        ;

        return $datagrid;
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

    /**
     * @return array Options
     */
    public function getOptions() {
        return array(
            'preview_url_callback' => function ($entity) {
                return $this->router->generate('post_details', array('slug' => $entity->getSlug()));
            },
        );
    }
}
