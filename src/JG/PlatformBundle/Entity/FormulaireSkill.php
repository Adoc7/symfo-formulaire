<?php

namespace JG\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jg_formulaire_skill")
 */

class FormulaireSkill
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="JG\PlatformBundle\Entity\Formulaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formulaire;


    /**
     * @ORM\ManyToOne(targetEntity="JG\PlatformBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;




    public function getId()
    {
        return $this->id;
    }

    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setFormulaire(Formulaire $formulaire)
    {
        $this->formulaire = $formulaire;
        return $this;
    }

    public function getFormulaire()
    {
        return $this->formulaire;
    }

    public function setSkill(Skill $skill)
    {
        $this->skill = $skill;
        return $this;
    }

    public function getSkill()
    {
        return $this->skill;
    }

}