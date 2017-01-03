<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Paragraph;
use AppBundle\Entity\Page;
use AppBundle\Form\Type\PageType;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\Common\Collections\Criteria;
use Wanjee\Shuwee\AdminBundle\Admin\Admin;
use Wanjee\Shuwee\AdminBundle\Datagrid\DatagridInterface;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeImage;
use Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeText;
use Wanjee\Shuwee\AdminBundle\Security\Voter\ContentVoter;

/**
 * Class ParagraphAdmin
 * @package AppBundle\Admin
 */
class PageAdmin extends Admin
{

    /**
     * @var \Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager
     */
    private $uploadableManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Router
     */
    private $router;

    /**
     * ModuleAdmin constructor.
     * @param \Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager $uploadableManager
     * @param EntityManager $entityManager
     * @param Router $router
     */
    public function __construct(UploadableManager $uploadableManager, EntityManager $entityManager, Router $router)
    {
        $this->uploadableManager = $uploadableManager;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Page::class;
    }

    /**
     * Return the main admin form for this content.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        return PageType::class;
    }

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return [
            'label' => '{0} Pages|{1} Page|]1,Inf] Pages',
            'preview_url_callback' => function ($entity) {
                return $this->router->generate('static_page', array('slug' => $entity->getSlug()));
            },
        ];
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
                [
                    'label' => '#',
                    'sortable' => true,
                ]
            )
            ->addField(
                'backgroundImage',
                DatagridFieldTypeImage::class,
                [
                    'label' => 'Background Image',
                    'base_path' => '',
                ]
            );
    }

    /**
     * @param UserInterface $user
     * @param string $action
     * @param null $object
     * @return int
     */
    public function hasAccess(UserInterface $user, $action, $object = null)
    {
        $grants = [
            ContentVoter::LIST_CONTENT => ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'],
            ContentVoter::VIEW_CONTENT => ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'],
            ContentVoter::CREATE_CONTENT => ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'],
            ContentVoter::UPDATE_CONTENT => ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'],
            ContentVoter::DELETE_CONTENT => ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'],
        ];

        // get required role
        $granted = [];
        if (array_key_exists($action, $grants)) {
            $granted = $grants[$action];
        }

        // check if user has required role
        if (array_intersect($granted, $user->getRoles())) {
            return VoterInterface::ACCESS_GRANTED;
        } else {
            return VoterInterface::ACCESS_DENIED;
        }
    }

    /**
     * @inheritDoc
     */
    public function postUpdate($entity)
    {
        $this->removeItems($entity, 'paragraphs', paragraph::class, 'page');

        foreach ($entity->getParagraphs() as $paragraph) {
            /** @var Paragraph $paragraph */
            if ($paragraph->getImage() instanceof UploadedFile) {
                $this->uploadableManager->markEntityToUpload(
                    $paragraph,
                    $paragraph->getImage()
                );
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function postPersist($entity)
    {
        foreach ($entity->getParagraphs() as $paragraph) {
            /** @var Paragraph $paragraph */
            if ($paragraph->getImage() instanceof UploadedFile) {
                $this->uploadableManager->markEntityToUpload(
                    $paragraph,
                    $paragraph->getImage()
                );
            }
        }
    }

    /**
     * @param $entity
     * @param $property
     * @param $repository
     */
    private function removeItems($entity, $property, $repository, $db_column)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $collection = $accessor->getValue($entity, $property);

        $current_items = [];
        foreach ($collection as $collection_item) {
            array_push($current_items, $collection_item->getId());
        }

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq($db_column, $entity));

        if (!empty($current_items)) {
            // In case we have no current_items anymore we do not need to add this
            // condition as it turns out an empty condition will not return any result
            $criteria->andWhere(Criteria::expr()->notIn('id', $current_items));
        }

        // Remove all the invalid answers from DB
        $repository = $this->entityManager->getRepository($repository);
        $deprecated_items = $repository->matching($criteria);

        foreach ($deprecated_items as $deprecated_item) {
            $this->entityManager->remove($deprecated_item);
        }

        // Do not flush here, will be done in Wanjee\Shuwee\AdminBundle\Controller\ContentController
    }

}