<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Block;
use AppBundle\Form\Type\BlockType;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;
use Wanjee\Shuwee\AdminBundle\Datagrid\DatagridInterface;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeBoolean;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeImage;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeText;
use Wanjee\Shuwee\AdminBundle\Datagrid\Filter\Type\DatagridFilterTypeChoice;
use Wanjee\Shuwee\AdminBundle\Datagrid\Filter\Type\DatagridFilterTypeText;

/**
 * Class BlockAdmin
 *
 * @package AppBundle\Admin
 */
class BlockAdmin extends Admin
{
    /**
     * @var \Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager
     */
    private $uploadableManager;

    /**
     *
     */
    function __construct(UploadableManager $uploadableManager)
    {
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
        return BlockType::class;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Block::class;
    }

    /**
     * @return array Options
     */
    public function getOptions() {
        return array(
            'label' => '{0} Blocks|{1} Block|]1,Inf] Blocks',
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
            ->addField(
                'promoted',
                DatagridFieldTypeBoolean::class,
                array(
                    'label' => 'Promoted',
                    'sortable' => true,
                    'toggle' => true,
                )
            )
        ;
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
            )
            ->addFilter(
                'promoted',
                DatagridFilterTypeChoice::class,
                [
                    'label' => 'Promoted',
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
