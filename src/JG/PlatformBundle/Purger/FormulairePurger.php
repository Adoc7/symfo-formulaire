<?php
namespace JG\PlatformBundle\Purger;
use Doctrine\ORM\EntityManagerInterface;
class FormulairePurger
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    // On injecte l'EntityManager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function purge($days)
    {
        $formulaireRepository      = $this->em->getRepository('JGPlatformBundle:Formulaire');
        $formulaireSkillRepository = $this->em->getRepository('JGPlatformBundle:FormulaireSkill');
        // date d'il y a $days jours
        $date = new \Datetime($days.' days ago');
        // On récupère les annonces à supprimer
        $listFormulaires = $formulaireRepository->getFormulairesBefore($date);
        // On parcourt les annonces pour les supprimer effectivement
        foreach ($listFormulaires as $formulaire) {
            // On récupère les FormulaireSkill liées à cette annonce
            $formulaireSkills = $formulaireSkillRepository->findBy(array('formulaire' => $formulaire));
            // Pour les supprimer toutes avant de pouvoir supprimer l'annonce elle-même
            foreach ($formulaireSkills as $formulaireSkill) {
                $this->em->remove($formulaireSkill);
            }
            // On peut maintenant supprimer l'annonce
            $this->em->remove($formulaire);
        }
        // Et on n'oublie pas de faire un flush !
        $this->em->flush();
    }
}