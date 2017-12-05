<?php
namespace JG\PlatformBundle\Repository;
use Doctrine\ORM\EntityRepository;


class ApplicationRepository extends EntityRepository
{
    public function getApplicationsWithFormulaire($limit)
    {
        $qb = $this->createQueryBuilder('a');

        // On fait une jointure avec l'entité Formulaire avec pour alias "adv"
        $qb
            ->innerJoin('a.formulaire','adv')
            ->addSelect('adv');
        ;

        // Puis on me retourn que $limit résultats
        $qb->setMaxResults($limit);

        // Enfin, on retourne le résultat
        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}