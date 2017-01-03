<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Paragraph
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="paragraph")
 * @ORM\Entity()
 * @Gedmo\Uploadable(allowOverwrite=true, pathMethod="getBasePath", filenameGenerator="ALPHANUMERIC")
 */
class Paragraph
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
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="paragraphs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $page;

    /**
     * @var string
     *
     * @ORM\Column(name="displayType", type="string", length=255, nullable = false)
     */
    private $displayType;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     groups = {"image_required"}
     * )
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Gedmo\UploadableFilePath
     */
    private $image;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     groups = {"body_required"}
     * )
     *
     * @ORM\Column(name="body", type="text", nullable = true)
     */
    private $body;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return Paragraph
     */
    public function removePage()
    {
        $this->page = null;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisplayType()
    {
        return $this->displayType;
    }

    /**
     * @param $displayType
     * @return mixed
     */
    public function setDisplayType($displayType)
    {
        $this->displayType = $displayType;

        return $this->displayType;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     * @return string
     */
    public function setImage($image)
    {
        // On form submission if no file is uploaded $image is set to null,
        // which removes the image value from the entity.
        // We want to preserve existing image.
        if (is_null($image)) {
            return $this;
        }

        $this->image = $image;

        return $this;
    }

    /**
     * Helper to get the base path where to store files.  Must be relative to web root.
     *
     * @return string
     */
    public function getBasePath()
    {
        return 'uploads/images/page/paragraph';
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     * @return mixed
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this->body;
    }



}