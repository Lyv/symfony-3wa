<?php
 
namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

#note1
use Troiswa\PublicBundle\Entity\Acteur;

use Symfony\Component\httpfoundation\request;

#note2
use Troiswa\PublicBundle\Form\ActeurType;

//pour débugger
use Doctrine\Common\Util\Debug;

use Symfony\Component\Validator\Constraints as Assert;

class ActeurController extends Controller{


  public function ActeursAction(){

    $em = $this -> getDoctrine() -> getManager();

    $acteurs = $em -> getRepository('TroiswaPublicBundle:Acteur') -> findAll();

        //pour débugger
        //die(Debug::dump($acteurs));

    return $this->render('TroiswaPublicBundle:Acteur:acteurs.html.twig', array('acteurs' => $acteurs));


}


public function ActeurAction($acteurid){
    #Afficher les infos d'un acteur
    #Attention, nom entre parenthèses doit etre pareil que dans routing
        
    $em = $this -> getDoctrine() -> getManager();

    $acteur = $em -> getRepository('TroiswaPublicBundle:Acteur') -> find($acteurid); //Find pour récupérer un seul élément, et prend en argument l'id

        return $this->render('TroiswaPublicBundle:Acteur:acteur.html.twig', array('acteur' => $acteur ));
    #Envoyer des infos dans la vue - tableau associatif

        //die(Debug::dump($film));

}

#creation de formulaire, version avec le fichier form / ActeurType
public function Ajouter_ActeurAction(Request $request){
#Classe Request, native de Symfony, récupère la requete et la met dans la variable
    #Ne pas oublier de faire un Use

        #Avant de créer un objet, il faut "use" la classe - #note 1
        $acteur = new Acteur();

        $formActeur = $this -> createForm(new ActeurType(), $acteur)
                 -> add ('Ajouter' , 'submit');
            #note 2 - à chaque New, faire un Use 
        
             if ("POST" === $request -> getMethod() ) #Déprécié 
             {
                //die("Post"); //si on est dans le post

                $formActeur -> bind($request) ; #Déprécié  //on met les infos tapées dans le formulaire
             
                if($formActeur -> isValid())
                {
                    

                    $acteur -> upload(); //pour rajouter image

                    #On enregistre grâce à Doctrine
                    $em = $this -> getDoctrine() -> getManager();
                    $em -> persist ($acteur); #reconnait l'objet
                    $em -> flush(); #sauvegarde de l'objet

                    #créer un message flash, qui n'apparait qu'une seule fois
                    #il faut qu'on se place dans une session
                    $session = $request -> getSession();
                    $session -> getFlashBag() -> add('info', 'Acteur créé');

                    #getFlashBag est natif de Symfony
                    #add prend comme paramètre une clé et un message - on peut mettre plusieurs messages dans la meme clé
                    #ensuite il suffit d'afficher dans twig         
                   


                    #Recharger le formulaire en get
                    #redirection vers le formulaire vide
                    return $this -> redirect($this -> generateUrl('troiswa_public_admin_ajouter_acteur'));
                    #generateUrl prend en param l'identifiant de la root


                    } 
             }   

         return $this -> render('TroiswaPublicBundle:Acteur:ajouter_acteur.html.twig', array('formActeur' => $formActeur -> createView()));


}


#creation de formulaire: version à la main
public function Editer_ActeurAction($acteurid, Request $request){

    #recuperer les infos de l'acteur ayant l'id avec Doctrine
    $em = $this -> getDoctrine() -> getManager();

    $acteur = $em -> getRepository('TroiswaPublicBundle:Acteur') -> find($acteurid); //Find pour récupérer un seul élément, et prend en argument l'id 

    #construire formulaire PUIS faire afficher info acteur dedans
    $formActeur = $this -> createFormBuilder($acteur) 
            -> add('prenom', 'text', array('required' => false)) #Requires = false enlève la condition d'html5
            -> add('nom' , 'text', array('required' => false))
            -> add('dateNaissance' , 'date', array('widget' => 'choice', 'years' => range(date("Y") ,'1900' ), 'required' => false))
            //-> add('dateNaissance' , 'date', array('widget' => 'single_text', 'format' => 'yyyy-MM-dd','required' => false) )
             -> add ('sexe' , 'choice', array('choices' => array('F' => 'Femme', 'M' => 'Homme'), 'expanded' => true, 'data' => 'F', 'required' => false) )
            -> add ('nationalite', null, array('required' => false))
            -> add ('biographie',null, array('required' => false))
            #équivalent de chainage à la suite
            #add('propriete de la classe acteur')

            -> add('fichier', 'file')
      



            -> add ('Modifier' , 'submit')    #équivalent de chainage à la suite  -> add ("Modifier l'acteur" , 'submit')
            -> getForm();

    #Tests de POST et de validation du formulaire  
       //if ("POST" === $request -> getMethod() )     #Déprécié   

            //{ 
                //die("post");
                $formActeur -> handleRequest($request) ; #Nouvelle version //on met les infos tapées dans le formulaire
                
                if($formActeur -> isValid())
                {
                  
                    $acteur -> upload();

                    $em = $this -> getDoctrine() -> getManager();
                    $em -> persist ($acteur); #reconnait l'objet
                    $em -> flush(); #sauvegarde de l'objet
 
                    $session = $request -> getSession();
                    $session -> getFlashBag() -> add('info', 'Acteur modifié');

                    return $this -> redirect($this -> generateUrl('troiswa_public_admin_editer_acteur', array( 'acteurid' => $acteurid)));
                    #generateUrl prend en param l'identifiant de la root, et ici le paramètre acteur id

                }

            //}

    return $this -> render('TroiswaPublicBundle:Acteur:editer_acteur.html.twig', array('formActeur' => $formActeur -> createView()));


        

    }






}


