<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Post;
use AppBundle\Form\Type\PostType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\DatagridInterface;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeBoolean;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeDate;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeImage;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeText;
use Wanjee\Shuwee\AdminBundle\Datagrid\Filter\Type\DatagridFilterTypeChoice;
use Wanjee\Shuwee\AdminBundle\Datagrid\Filter\Type\DatagridFilterTypeText;

/**
 * Class PostAdmin
 *
 * @package AppBundle\Admin
 */
class PostAdmin extends Admin
{
    /**
     * @var \Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager
     */
    private $uploadableManager;

    /**
     * @var Router
     */
    private $router;

    /**
     *
     */
    function __construct(Router $router, UploadableManager $uploadableManager)
    {
        $this->router = $router;
        $this->uploadableManager = $uploadableManager;
    }

    /**
     * Return the main admin form for this content.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        // Must return a fully qualified class name
        return PostType::class;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Post::class;
    }

    /**
     * @return array Options
     */
    public function getOptions() {
        return array(
            'label' => '{0} Posts|{1} Post|]1,Inf] Posts',
            'description' => 'A blog post is a journal entry.',
            'menu_section' => 'Content',
            'preview_url_callback' => function ($entity) {
                return $this->router->generate('post_details', array('slug' => $entity->getSlug()));
            },
        );
    }

    /**
     * @inheritdoc
     */
    public function getDatagridOptions()
    {
        return [
            'limit_per_page' => 25,
            'default_sort_column' => 'id',
            'default_sort_order' => 'asc',
            'show_actions_column' => true,
        ];
    }


    /**
     * @inheritdoc
     */
    public function attachFields(DatagridInterface $datagrid)
    {
        $datagrid
            ->addField(
                'id',
                DatagridFieldTypeText::class,
                array(
                    'label' => '#',
                    'sortable' => true,
                )
            )
            ->addField(
                'image',
                DatagridFieldTypeImage::class,
                array(
                    'label' => 'Image',
                    'base_path' => ''
                )
            )
            ->addField(
                'title',
                DatagridFieldTypeText::class,
                array(
                    'label' => 'Title',
                    'sortable' => true,
                )
            )
            ->addField(
                'publishedAt',
                DatagridFieldTypeDate::class,
                array(
                    'label' => 'Publication date',
                    'sortable' => true,
                    'date_format' => 'd/m/Y',
                )
            )
            ->addField(
                'status',
                DatagridFieldTypeBoolean::class,
                array(
                    'label' => 'Published',
                    'sortable' => true,
                    'label_true' => 'Yes',
                    'label_false' => 'No',
                    'toggle' => true,
                )
            )
        ;

        return $datagrid;
    }

    /**
     * @inheritdoc
     */
    public function attachFilters(DatagridInterface $datagrid)
    {
        $datagrid
            ->addFilter(
                'title',
                DatagridFilterTypeText::class,
                [
                    'label' => 'Title',
                ]
            )
            ->addFilter(
                'status',
                DatagridFilterTypeChoice::class,
                [
                    'label' => 'Published',
                    'choices' => [
                        'Yes' => 1,
                        'No' => 0,
                    ],
                ]
            );
    }

    /**
     * @inheritDoc
     */
    public function postUpdate($entity)
    {
        if ($entity->getImage() instanceof UploadedFile) {
            $this->uploadableManager->markEntityToUpload(
                $entity,
                $entity->getImage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function postPersist($entity)
    {
        if ($entity->getImage() instanceof UploadedFile) {
            $this->uploadableManager->markEntityToUpload(
                $entity,
                $entity->getImage()
            );
        }
    }
}
