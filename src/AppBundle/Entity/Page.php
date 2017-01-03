<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Page
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="page")
 * @ORM\Entity()
 * @Gedmo\Uploadable(allowOverwrite=true, pathMethod="getBasePath", filenameGenerator="ALPHANUMERIC")
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroundImage", type="string", length=255, nullable=false)
     * @Gedmo\UploadableFilePath
     * @Assert\NotNull(
     *     message="Please select an image",
     *     groups = {"default"}
     * )
     */
    private $backgroundImage;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     groups = {"default"}
     * )
     *
     * @ORM\Column(name="title", type="string", length=255, nullable = false)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"}, updatable = true, unique = true)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="Paragraph", mappedBy="page", cascade={"persist", "remove"})
     */
    private $paragraphs;

    /**
     * @var boolean
     *
     * @ORM\Column(name="menuItem", type="boolean", nullable = true)
     */
    private $menuItem;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message = "Label is required when Menu Item is checked",
     *     groups = {"menu_item_checked"}
     * )
     *
     * @ORM\Column(name="menuLabel", type="string", length=255, nullable = true)
     */
    private $menuLabel;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * StepMCQ constructor.
     */
    public function __construct()
    {
        $this->paragraphs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * @param $backgroundImage
     * @return string
     */
    public function setBackgroundImage($backgroundImage)
    {
        // On form submission if no file is uploaded $image is set to null,
        // which removes the image value from the entity.
        // We want to preserve existing image.
        if (is_null($backgroundImage)) {
            return $this;
        }

        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    /**
     * Helper to get the base path where to store files.  Must be relative to web root.
     *
     * @return string
     */
    public function getBasePath()
    {
        return 'uploads/images/page';
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return mixed
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this->slug;
    }

    /**
     * @return ArrayCollection
     */
    public function getParagraphs()
    {
        return $this->paragraphs;
    }

    /**
     * @param ArrayCollection $paragraphs
     */
    public function setParagraphs($paragraphs)
    {
        $this->paragraphs = $paragraphs;
    }

    /**
     * @param Paragraph $paragrah
     */
    public function addParagraph(Paragraph $paragrah)
    {
        $paragrah->setPage($this);
        $this->paragraphs->add($paragrah);
    }

    /**
     * @param Paragraph $paragraph
     */
    public function removeParagraph(Paragraph $paragraph)
    {
        $this->paragraphs->removeElement($paragraph);
        $paragraph->removePage();
    }

    /**
     * @return mixed
     */
    public function getMenuItem()
    {
        return $this->menuItem;
    }

    /**
     * @param $menuItem
     * @return mixed
     */
    public function setMenuItem($menuItem)
    {
        $this->menuItem = $menuItem;

        return $this->menuItem;
    }

    /**
     * @return mixed
     */
    public function getMenuLabel()
    {
        return $this->menuLabel;
    }

    /**
     * @param $menuLabel
     * @return mixed
     */
    public function setMenuLabel($menuLabel)
    {
        $this->menuLabel = $menuLabel;

        return $this->menuLabel;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param $weight
     * @return int
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return Page
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Page
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Page
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}