<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Block
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="block")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BlockRepository")
 * @Gedmo\Uploadable(allowOverwrite=true, pathMethod="getBasePath", filenameGenerator="ALPHANUMERIC")
 */
class Block implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min = "10",
     *     minMessage = "Block content is too short ({{ limit }} characters minimum)"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\UploadableFilePath
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $caption;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="promoted", type="boolean")
     */
    private $promoted;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight")
     */
    private $weight = 0;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
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
        return 'uploads/blocks';
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return boolean
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return boolean
     */
    public function isPromoted()
    {
        return $this->promoted;
    }

    /**
     * @param boolean $promoted
     */
    public function setPromoted($promoted)
    {
        $this->promoted = $promoted;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Block
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
     * @return Block
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

    /**
     * @return mixed Returns data which can be serialized by json_encode().
     */
    function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'promoted' => $this->promoted,
        );
    }
}
