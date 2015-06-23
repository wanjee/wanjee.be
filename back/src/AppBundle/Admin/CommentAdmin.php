<?php
namespace AppBundle\Admin;

use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;

/**
 * Class PostAdmin
 *
 * @package AppBundle\Admin
 */
class CommentAdmin extends Admin
{
    /**
     * Return the main admin form for this content.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        // Return either a fully qualified class name
        // or the service id of your form if it is defined as a service
        return 'AppBundle\Form\CommentType';
    }

    /**
     * @return Datagrid
     */
    public function getDatagrid()
    {
        $datagrid = new Datagrid($this, array('limit_per_page' => 25));

        $datagrid
            ->addField('id', 'text', array('sortable' => true))
            ->addField('content', 'text', array('sortable' => true))
            ->addField('authorEmail', 'text');

        return $datagrid;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'AppBundle:Comment';
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return 'AppBundle\Entity\Comment';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return '{0} Comments|{1} Comment|]1,Inf] Comments';
    }
}