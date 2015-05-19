<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Please don't leave your comment blank!")
     * @Assert\Length(
     *     min = "5",
     *     minMessage = "Comment is too short ({{ limit }} characters minimum)",
     *     max = "10000",
     *     maxMessage = "Comment is too long ({{ limit }} characters maximum)"
     * )
     */
    private $content;
    /**
     * @ORM\Column(type="string")
     * @Assert\Email()
     */
    private $authorEmail;
    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $publishedAt;

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(Post $post = null)
    {
        $this->post = $post;
    }
}