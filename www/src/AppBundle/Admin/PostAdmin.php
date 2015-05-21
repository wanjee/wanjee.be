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
        // Return either a fully qualified class name
        // or the service id of your form if it is defined as a service
        return 'AppBundle\Form\PostType';
    }

    /**
     * @return Datagrid
     */
    public function getDatagrid()
    {
        $datagrid = new Datagrid($this);

        $datagrid
          ->addField('id', 'text', array(
              'label' => '#',
            )
          )
          ->addField('title', 'text', array(
              'label' => 'Title',
            )
          )
          ->addField('authorEmail', 'text', array(
              'label' => 'Author',
            )
          )
          ->addField('publishedAt', 'date', array(
              'label' => 'Published',
              'date_format' => 'F j, Y',
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