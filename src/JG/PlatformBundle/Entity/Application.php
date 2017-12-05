<?php

namespace JG\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="jg_application")
 * @ORM\Entity(repositoryClass="JG\PlatformBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="JG\PlatformBundle\Entity\Formulaire", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formulaire;



    /**
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    public function __construct()
    {
        $this->date = new \Datetime();
    }


    /**
     * @ORM\PrePersist
     */
    public function increase()
    {
        $this->getFormulaire()->increaseApplication();

    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $this->getFormulaire()->decreaseApplication();
    }




    // reste des attributs

    public function setFormulaire(Formulaire $formulaire)
    {
        $this->formulaire = $formulaire;
        return $this;
    }

    public function getFormulaire()
    {
        return $this->formulaire;
    }




    public function getId()
    {
        return $this->id;
    }



    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    public function getAuthor($author)
    {
        $this->author = $author;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Application
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
