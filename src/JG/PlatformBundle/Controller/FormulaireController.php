<?php

// src/OC/PlatformBundle/Controller/AdvertController.php
namespace JG\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormulaireController extends Controller
{

//    public function indexAction($page)
    public function indexAction()
    {
        //On ne sait pas combien de pages il y a
        // Mais on sait qu'une page doit être supérieure ou égale à 1

//        if ($page < 1) {
//            // On déclenche une exception NotFoundHttpException, cela va afficher
//            // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
//            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
//        }

        // Ici, on récupérera la liste des annonces, puis on la passera au template
        // Mais pour l'instant, on ne fait qu'appeler le template

        return $this->render('JGPlatformBundle:Formulaire:index.html.twig', array(

               'listAdverts' => array(
                   array(
                     'title'     => 'Recherche développpeur Symfony',
                     'id'        => 1,
                     'author'    => 'Alexandre',
                     'content'   => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                     'date'      => new \Datetime()),
                   array(
                      'title'    => 'Mission de webmaster',
                      'id'       => 2,
                      'author'   => 'hugo',
                      'content'  => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla...',
                      'date'     => new \Datetime()),
                   array(
                       'title'   => 'Offre de stage de webdesigner',
                       'id'      => 3,
                       'author'  => 'Mathieu',
                       'content' => 'Nous proposons un poste pour webdesigner. Blabla...',
                       'date'    => new \Datetime()),
                )));
    }

    public function viewAction($id)
    {
        // Ici, on récupérera l'annonce correspondante à $id

        $advert = array(
            'title'   =>'Recherche développeur Symphony2',
            'id'      => $id,
            'author'  => 'Alexandee',
            'content' => 'Nous recherchons un développeur Symphony2 débutant sur Lyon. Blabla...',
            'date'    => new \Datetime()
        );

        return $this->render('JGPlatformBundle:Formulaire:view.html.twig', array(
            'advert' => $advert
        ));
    }

    public function editAction($id, Request $request)
    {
        // Ici, on récupérera l'annonce correspondant à $id

        // Même mécanisme que pour l'ajout




//        if ($request->isMethod('POST')) {
//            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
//
//            return $this->redirectToRoute('jg_platform_view', array('id' => 5));
//        }
                                         



        $advert = array(
            'title'   => 'Recherche développeur Symphony',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symphony débutant sur Lyon. Blabla...',
            'date'    => new \Datetime()
        );

        return $this->render('JGPlatformBundle:Formulaire:edit.html.twig', array(
            'advert' => $advert
        ));

    }

    public function deleteAction($id)
    {
        // Ici, on récupérera l'annonce correspondant à $id
        // Ici, on gérera la suppression de l'annonce en question


        return $this->render('JGPlatformBundle:Formulaire:delete.html.twig');
    }



//    public function addAction()
//    {
//        // On veut avoir l'URL de l'annonce d'id 5.
////        $url = $this->get('router')->generate(
//        $url = $this->generateUrl(
//            'jg_platform_view', // 1er argument : le nom de la route
//            array('id' => 5)    // 2e argument : les valeurs des paramètres
//        );
//        // $url vaut « /platform/advert/5 »
//        return new Response("L'URL de l'annonce d'id 5 est : " . $url);
//    }
//}

//public function viewAction($id)
//{
//    return $this->render('JGPlatformBundle:Formulaire:view.html.twig', array(
//        'id' => $id
//    ));
//}

// Ajoutez cette méthode :
public function addAction(Request $request)
{
    $session = $request->getSession();

    // Bien sûr, cette méthode devra réellement ajouter l'annonce
    // Mais faisons comme si c'était le cas

    $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

    // Le « flashBag » est ce qui contient les messages flash dans la session
    // Il peut bien sûr contenir plusieurs messages :

    $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');
    // Puis on redirige vers la page de visualisation de cette annonce
    return $this->redirectToRoute('jg_platform_view', array('id' => 5));
    }

    public function menuAction($limit)
    {
//        // On fixe en dur une liste ici, bien entendu par la suite
//        // on la récupérera depuis la BDD !
        $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche développeur Symphony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner'),
           );
//
        return $this->render('JGPlatformBundle:Formulaire:menu.html.twig', array(
//            // Tout l'intérêt est ici : le contrôleur passe
//            // les variables nécessaires au template !
            'listAdverts' => $listAdverts
        ));

    }

}





//    public function viewAction($id, Request $request)
//    {
//        // On récupère notre paramètre tag
//        $tag = $request->query->get('tag');
//
//        // On utilise le raccourci : il crée un objet Response
//        // Et lui donne comme contenu le contenu du template
//        return $this->render('JGPlatformBundle:Formulaire:view.html.twig', array(
//            'id'  => $id,
//            'tag' => $tag,
//        ));
//    }



//// SESSION
// public function viewAction($id, Request $request)
//    {
//        // Récupération de la session
//        $session = $request->getSession();
//        // On récupère le contenu de la variable user_id
//        $userId = $session->get('user_id');
//        // On définit une nouvelle valeur pour cette variable user_id
//        $session->set('user_id', 91);
//        // On n'oublie pas de renvoyer une réponse
//        return new Response("<body>Je suis une page de test, je n'ai rien à dire</body>");
//    }
//
//}



///JSON
//    public function viewAction($id)
//    {
//        // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
//        $response = new Response(json_encode(array('id' => $id)));
//
//        // Ici, nous définissons le Content-type pour dire au navigateur
//        // que l'on renvoie du JSON et non du HTML
//        $response->headers->set('Content-Type', 'application/json');
//        return $response;
//    }





//    public function viewAction($id)
//    {
//        return new Response("Affichage de l'annonce d'id : ".$id);
//    }


//    // La route fait appel à OCPlatformBundle:Advert:view,
//    // on doit donc définir la méthode viewAction.
//    // On donne à cette méthode l'argument $id, pour
//    // correspondre au paramètre {id} de la route
//    public function viewAction($id)
//
//    {
//        // $id vaut 5 si l'on a appelé l'URL /platform/advert/5
//
//        // Ici, on récupèrera depuis la base de données
//        // l'annonce correspondant à l'id $id.
//        // Puis on passera l'annonce à la vue pour
//        // qu'elle puisse l'afficher
//
//        return new Response("Affichage de l'annonce d'id : ".$id);
//    }
//
//    // ... et la méthode indexAction que nous avons déjà créée
//
//    // On récupère tous les paramètres en arguments de la méthode
//    public function viewSlugAction($slug, $year, $_format)
//    {
//        return new Response(
//            "On pourrait afficher l'annonce correspondant au
//            slug '".$slug."', créée en ".$year." et au format ".$_format."."
//        );
//    }




//}
//namespace JG\PlatformBundle\Controller;
//
//use JG\PlatformBundle\Entity\Formulaire;
//
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\FormType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//
//
//class FormulaireController extends Controller
//{
//    public function addAction(Request $request)
//    {
//        // On crée un objet Advert
//        $formulaire = new Formulaire();
//        // On crée le FormBuilder grâce au service form factory
//        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $formulaire);
//        // On ajoute les champs de l'entité que l'on veut à notre formulaire
//        $formBuilder
//            ->add('date',      DateType::class)
//            ->add('title',     TextType::class)
//            ->add('content',   TextareaType::class)
//            ->add('author',    TextType::class)
//            ->add('published', CheckboxType::class)
//            ->add('save',      SubmitType::class)
//        ;
//        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
//        // À partir du formBuilder, on génère le formulaire
//        $form = $formBuilder->getForm();
//        // On passe la méthode createView() du formulaire à la vue
//        // afin qu'elle puisse afficher le formulaire toute seule
//       return $this->render('JGPlatformBundle:Formulaire:add.html.twig', array(
//            'form' => $form->createView(),
//        ));
//    }
//}

