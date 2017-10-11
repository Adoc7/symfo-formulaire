<?php
namespace JG\PlatformBundle\Controller;

use JG\PlatformBundle\Entity\Formulaire;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class FormulaireController extends Controller
{
    public function addAction(Request $request)
    {
        // On crée un objet Advert
        $formulaire = new Formulaire();
        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $formulaire);
        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('date',      DateType::class)
            ->add('title',     TextType::class)
            ->add('content',   TextareaType::class)
            ->add('author',    TextType::class)
            ->add('published', CheckboxType::class)
            ->add('save',      SubmitType::class)
        ;
        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
       return $this->render('JGPlatformBundle:Formulaire:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}


//namespace JG\PlatformBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Response;


//class FormulaireController extends Controller
//{
//    public function page1Action()
//    {
//        $cont1 = $this->get('templating')->render('JGPlatformBundle:Formulaire:page1.html.twig');
//    return new Response($cont1);
//    }
//
//    public function page2Action()
//    {
//        $cont2 = $this->get('templating')->render('JGPlatformBundle:Formulaire:page2.html.twig');
//        return new Response($cont2);
//    }
//
//}

// src/OC/PlatformBundle/Controller/AdvertController.php
//namespace JC\PlatformBundle\Controller;
