<?php

namespace JG\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="jg_application")
 * @ORM\Entity(repositoryClass="JG\PlatformBundle\Repository\ApplicationRepository")
 */


class Application
{

    /**
     * @ORM\ManyToOne(targetEntity="JG\PlatformBundle\Entity\Formulaire")
     * @ORM\JoinColumn(nullable=false)
     */

    private $formulaire;

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

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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


    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->date = new \Datetime();
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


}



