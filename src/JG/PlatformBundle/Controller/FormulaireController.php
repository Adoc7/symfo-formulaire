<?php

namespace JG\PlatformBundle\Controller;

use JG\PlatformBundle\Entity\Formulaire;
use JG\PlatformBundle\Entity\FormulaireSkill;
use JG\PlatformBundle\Entity\Image;
use JG\PlatformBundle\Entity\Application;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class FormulaireController extends Controller
{
//    public function indexAction($page)
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $formulaire = $em
            ->getRepository('JGPlatformBundle:Formulaire')
            ->findAll();

//        dump($formulaire);

        return $this->render('JGPlatformBundle:Formulaire:index.html.twig', array(
            'formulaire' => $formulaire
        ));

        //On ne sait pas combien de pages il y a
        // Mais on sait qu'une page doit être supérieure ou égale à 1

//        if ($page < 1) {
//            // On déclenche une exception NotFoundHttpException, cela va afficher
//            // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
//            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
//        }

        // Ici, on récupérera la liste des annonces, puis on la passera au template
        // Mais pour l'instant, on ne fait qu'appeler le template
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $formulaire = $em
            ->getRepository('JGPlatformBundle:Formulaire')
            ->find($id);

                dump($formulaire);


        if (null === $formulaire) {
            throw new NotFoundHttpException("L'annonce d'id" . $id . " n'existe pas.");
        }

        // On récupère la liste des candidatures de cette annonce

        $listApplications = $em
            ->getRepository('JGPlatformBundle:Application')
            ->findBy(array('formulaire' => $formulaire));

        // On récupère maintenant la liste des FormulaireSkill
        $listFormulaireSkills = $em
            ->getRepository('JGPlatformBundle:FormulaireSkill')
            ->findBy(array('formulaire' => $formulaire));
//        dump($listFormulaireSkills);


        return $this->render('JGPlatformBundle:Formulaire:view.html.twig', array(
            'formulaire'            => $formulaire,
            'listApplications'      => $listApplications,
            'listFormulaireSkills'  => $listFormulaireSkills
        ));
    }



    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $formulaire = $em->getRepository('JGPlatformBundle:Formulaire')->find($id);
        if (null === $formulaire) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }

        // La méthode findAll retourne toutes les catégories de la base de données
        $listCategories = $em->getRepository('JGPlatformBundle:Category')->findAll();

        // On boucle sur les catégories pour les lier à l'annonce
        foreach ($listCategories as $category) {
            $formulaire->addCategory($category);
        }

        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Formulaire est le proprietaire, donc inutile de persister car o,n l'a récupérée depuis Doctrine.

        // Etape 2 : Enregistrement
        $em->flush();
        // ... reste de la méthode


        $formulaire = array(
            'title' => 'Recherche développeur Symphony',
            'id' => $id,
            'author' => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symphony débutant sur Lyon. Blabla...',
            'date' => new \Datetime()
        );

        return $this->render('JGPlatformBundle:Formulaire:edit.html.twig', array(
            'formulaire' => $formulaire
        ));
    }



    public function deleteAction($id)
    {
        // Ici, on récupérera l'annonce correspondant à $id
        // Ici, on gérera la suppression de l'annonce en question

        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $formulaire = $em->getRepository('JGPlatformBundle:Formulaire')->find($id);

        if (null === $formulaire){
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
            // On boucle sur les catégories de l'annonce pour les supprimer
            foreach ($formulaire->getCategories() as $category){
            $formulaire->removeCategory($category);

            // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
                // ICI, Formulaire est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine.

                // On déclenche la modification
                $em->flush();

            }
        }


// Ajoutez cette méthode :
    public function addAction(Request $request)
    {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Création de l'entité
        $formulaire = new Formulaire();
        $formulaire->setTitle('Recherche développeur Symphony2.');
        $formulaire->setAuthor('Alexandre');
        $formulaire->setContent("Nous recherchons un développeur Symphony2 débutant sur Lyon. Blabla...");

        // On récupère toutes les compétences possibles
        $listSkills = $em->getRepository('JGPlatformBundle:Skill')->findAll();

        // Pour chaque compétence
        foreach ($listSkills as $skill) {


            // On crée une nouvelle "relation entre 1 annonce et 1 compétence"
            $formulaireSkill = new FormulaireSkill();

            // On la lie à l'annonce, qui est ici toujours la même.
            $formulaireSkill->setFormulaire($formulaire);

            // On la lie à la compétence, qui change ici dans la boucle foreach
            $formulaireSkill->setSkill($skill);

            // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
            $formulaireSkill->setLevel('Expert');

            // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
            $em->persist($formulaireSkill);
        }

        // Doctrine ne connaît pas encore 'entité $formulaire. Si vous n'avez pas définit la relation FormulaireSkill
        // avec un cascade persist, alors on peut persister $formulaire

        $em->persist($formulaire);

        // On déclenche l'enregistrement
        $em->flush();

        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        // On lie l'image à l'annonce
        $formulaire->setImage($image);

        // Création d'une première candidature
        $application1= new Application();
        $application1->setAuthor('Marine');
        $application1->setContent("J'ai toutes les qualités requises.");

        // Création d'une deuxième candidature
        $application2= new Application();
        $application2->setAuthor('Pierre');
        $application2->setContent("Je suis très motivé.");

        // On lie les candidatures à l'annonce
         $application1->setFormulaire($formulaire);
         $application2->setFormulaire($formulaire);

        // On peut ne pas définir ni la date ni la publication,
        // car ces attributs sont définis automatiquement dans le constructeur

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        //Etape 1 : on "persiste" l'entité
        $em->persist($formulaire);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);


        // définie dans l'entité Application et non formulaire. On doit donc tout persister à la main ici.
        $em->persist($application1);
        $em->persist($application2);

        // Étape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();

        // Reste de la méthode qu'on avait déjà écrit
        if ($request->isMethod('POST')) {
//            $request->getSession()getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            $request->get('Session')->setFlash('notice', 'Annonce bien enregistrée.');
        return $this->redirect($this->generateUrl('jg_platform_view', array('id' => $formulaire->getId())));
    }

        return $this->render('JGPlatformBundle:Formulaire:add.html.twig');

    }



//    $this->get('mailer');
//    // On récupère le service
//    $antispam = $this->container->get('jg_platform.antispam');
////
////    // Je pars du principe que $text contient le texte d'un message quelconque
//    $text="...";
//    if ($antispam->isSpam($text)){
//        throw new \exception('Votre message a été détecté comme spam !');
//    }
//    // Ici le message n'est pas un spam
//
//    $session = $request->getSession();
//
//    // Bien sûr, cette méthode devra réellement ajouter l'annonce
//    // Mais faisons comme si c'était le cas
//
//    $session->getFlashBag()->add('info', 'Annonce bien enregistrée');
//
//    // Le « flashBag » est ce qui contient les messages flash dans la session
//    // Il peut bien sûr contenir plusieurs messages :
//
//    $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');
//    // Puis on redirige vers la page de visualisation de cette annonce
//    return $this->redirectToRoute('jg_platform_view', array('id' => 5));
//    }

    public function menuAction($limit)
    {
//        // On fixe en dur une liste ici, bien entendu par la suite
//        // on la récupérera depuis la BDD !
        $listFormulaires = array(
            array('id' => 2, 'title' => 'Recherche développeur Symphony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner'),
           );
//
        return $this->render('JGPlatformBundle:Formulaire:menu.html.twig', array(
//            // Tout l'intérêt est ici : le contrôleur passe
//            // les variables nécessaires au template !
            'listFormulaires' => $listFormulaires
        ));
    }


        public function editImageAction($formulaireId)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère l'annonce
        $formulaire = $em->getRepository('JGPlatformBundle:Formulaire')->find($formulaireId);

        // On modifie l'URL de l'image par exemple
        $formulaire->getImage()->setUrl('test.png');

        // On n'a pas besoin de persister l'annonce ni l'image.
        // Rappelez-vous, ces entités sont automatiquement persistées car
        // on les a récupérées depuis Doctrine lui-même


        // On déclenche la modification

        $em->flush();

        return new Response('OK');


    }



}
