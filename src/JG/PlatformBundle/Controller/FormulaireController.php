<?php

namespace JG\PlatformBundle\Controller;

use JG\PlatformBundle\Entity\Formulaire;
use JG\PlatformBundle\Form\FormulaireType;
use JG\PlatformBundle\Form\FormulaireEditType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class FormulaireController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
        // Ici je fixe le nombre d'annonces par page à 3
        // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
        $nbPerPage = 3;
        // On récupère notre objet Paginator
        $listFormulaires = $this->getDoctrine()
            ->getManager()
            ->getRepository('JGPlatformBundle:Formulaire')
            ->getFormulaires($page, $nbPerPage)
        ;
        // On calcule le nombre total de pages grâce au count($listFormulaires) qui retourne le nombre total d'annonces
        $nbPages = ceil(count($listFormulaires) / $nbPerPage);
        // Si la page n'existe pas, on retourne une 404
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        // On donne toutes les informations nécessaires à la vue
        return $this->render('JGPlatformBundle:Formulaire:index.html.twig', array(
            'listFormulaires' => $listFormulaires,
            'nbPages'     => $nbPages,
            'page'        => $page,
        ));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $formulaire = $em->getRepository('JGPlatformBundle:Formulaire')->find($id);
        // $formulaire est donc une instance de JG\PlatformBundle\Entity\Formulaire
        // ou null si l'id $id n'existe pas, d'où ce if :
        if (null === $formulaire) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        // Récupération de la liste des candidatures de l'annonce
        $listApplications = $em
            ->getRepository('JGPlatformBundle:Application')
            ->findBy(array('formulaire' => $formulaire))
        ;
        // Récupération des FormulaireSkill de l'annonce
        $listFormulaireSkills = $em
            ->getRepository('JGPlatformBundle:FormulaireSkill')
            ->findBy(array('formulaire' => $formulaire))
        ;

        return $this->render('JGPlatformBundle:Formulaire:view.html.twig', array(
            'formulaire'           => $formulaire,
            'listApplications'     => $listApplications,
            'listFormulaireSkills' => $listFormulaireSkills,
        ));
    }
    public function addAction(Request $request)
    {
        $formulaire = new Formulaire();
        $form   = $this->get('form.factory')->create(FormulaireType::class, $formulaire);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirectToRoute('jg_platform_view', array('id' => $formulaire->getId()));
        }
        return $this->render('JGPlatformBundle:Formulaire:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formulaire = $em->getRepository('JGPlatformBundle:Formulaire')->find($id);
        if (null === $formulaire) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        $form = $this->get('form.factory')->create(FormulaireEditType::class, $formulaire);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            return $this->redirectToRoute('jg_platform_view', array('id' => $formulaire->getId()));
        }
        return $this->render('JGPlatformBundle:Formulaire:edit.html.twig', array(
            'formulaire' => $formulaire,
            'form'   => $form->createView(),
        ));
    }
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $formulaire = $em->getRepository('JGPlatformBundle:Formulaire')->find($id);
        if (null === $formulaire) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($formulaire);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
            return $this->redirectToRoute('jg_platform_home');
        }

        return $this->render('JGPlatformBundle:Formulaire:delete.html.twig', array(
            'formulaire' => $formulaire,
            'form'   => $form->createView(),
        ));
    }
    public function menuAction($limit)
    {
        $em = $this->getDoctrine()->getManager();
        $listFormulaires = $em->getRepository('JGPlatformBundle:Formulaire')->findBy(
            array(),                 // Pas de critère
            array('date' => 'desc'), // On trie par date décroissante
            $limit,                  // On sélectionne $limit annonces
            0                        // À partir du premier
        );
        return $this->render('JGPlatformBundle:Formulaire:menu.html.twig', array(
            'listFormulaires' => $listFormulaires
        ));
    }
    // Méthode facultative pour tester la purge
    public function purgeAction($days, Request $request)
    {
        // On récupère notre service
        $purger = $this->get('jg_platform.purger.formulaire');
        // On purge les annonces
        $purger->purge($days);
        // On ajoute un message flash arbitraire
        $request->getSession()->getFlashBag()->add('info', 'Les annonces plus vieilles que '.$days.' jours ont été purgées.');
        // On redirige vers la page d'accueil
        return $this->redirectToRoute('jg_platform_home');
    }

}