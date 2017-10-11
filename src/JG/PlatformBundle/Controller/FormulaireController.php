<?php

// src/OC/PlatformBundle/Controller/AdvertController.php
namespace JG\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; // N'oubliez pas ce use !
use Symfony\Component\HttpFoundation\Response;

class FormulaireController extends Controller
{
    public function addAction()
    {
        // On veut avoir l'URL de l'annonce d'id 5.
//        $url = $this->get('router')->generate(
            $url = $this->generateUrl(
           'jg_platform_view', // 1er argument : le nom de la route
            array('id' => 5)    // 2e argument : les valeurs des paramètres
        );
        // $url vaut « /platform/advert/5 »
        return new Response("L'URL de l'annonce d'id 5 est : ".$url);
    }

        // Vous avez accès à la requête HTTP via $request
        // On injecte la requête dans les arguments de la méthode
        public function viewAction($id, Request $request)
        {
            // On récupère notre paramètre tag
            $tag = $request->query->get('tag');

            return new Response(
                "Affichage de l'annonce d'id : " . $id . ", avec le tag : " . $tag
            );
        }

}

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

