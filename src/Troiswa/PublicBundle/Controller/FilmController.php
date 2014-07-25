<?php
 
namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Troiswa\PublicBundle\Entity\Film;

use Symfony\Component\httpfoundation\request;

use Troiswa\PublicBundle\Form\FilmType;

//pour débugger
use Doctrine\Common\Util\Debug;

class FilmController extends Controller{


  public function filmsAction(){
#Afficher tous les films    
        /*
        $films = array(
            array("id" => "1",  "titre" => "Rambo" , "synopsis" => "Rambo tue tout le monde!!", "categorie" => "Action"), 
            array("id" => "2", "titre" => "Coup de foudre à Notting Hill" , "synopsis" => "Hugh Grant et Julia Roberts tombent amoureux à Notting Hill", "categorie" => "Amour"), 
            array("id" => "3", "titre" => "Avatar" , "synopsis" => "Un homme débarque sur une planète extraterrestre, et s'intègre dans la vie locale", "categorie" => "Aventure"),
            array("id" => "4", "titre" => "Sex And the City" , "synopsis" => "Les aventures de Carrie, Miranda, Charlotte et Samantha, toujours fabuleuses à New york", "categorie" => "Amour"), 
            array("id" => "5", "titre" => "Kill Bill" , "synopsis" => "Uma Turman tue tout le monde!!", "categorie" => "Action"),
            );

        */


        $em = $this -> getDoctrine() -> getManager();

        $films = $em -> getRepository('TroiswaPublicBundle:Film') -> findAll();

        //pour débugger
        //die(Debug::dump($films));

        return $this->render('TroiswaPublicBundle:Film:films.html.twig', array('films' => $films ));
    #Envoyer des infos dans la vue - tableau associatif

    }




 public function filmAction($filmid){
    #Afficher un seul film
    #Attention, nom entre parenthèses doit etre pareil que dans routing
        
    $em = $this -> getDoctrine() -> getManager();

     $film = $em -> getRepository('TroiswaPublicBundle:Film') -> find($filmid); //Find pour récupérer un seul élément, et prend en argument l'id

        return $this->render('TroiswaPublicBundle:Film:film.html.twig', array('film' => $film ));
    #Envoyer des infos dans la vue - tableau associatif

        //die(Debug::dump($film));

    }




 public function Ajouter_FilmAction(Request $request){
      
    //die('post');

    $film = new Film();

    $formFilm = $this -> createForm(new FilmType(), $film)
        -> add('Ajouter', 'submit');


     $formFilm -> handleRequest($request) ; #Nouvelle version //on met les infos tapées dans le formulaire
                
                if($formFilm -> isValid())
                {
                    $film -> upload();

                    $em = $this -> getDoctrine() -> getManager();
                    $em -> persist ($film); #reconnait l'objet
                    $em -> flush(); #sauvegarde de l'objet
 
                    $session = $request -> getSession();
                    $session -> getFlashBag() -> add('info', 'Film Ajouté');

                    return $this -> redirect($this -> generateUrl('troiswa_public_admin_ajouter_film'));
                    #generateUrl prend en param l'identifiant de la root, et ici le paramètre acteur id

                }


      return $this -> render('TroiswaPublicBundle:Film:ajouter_film.html.twig', array('formFilm' => $formFilm -> createView()));


}


 public function Editer_FilmAction($filmid, Request $request){
      
    //die('post');

     #recuperer les infos du film ayant l'id avec Doctrine
    $em = $this -> getDoctrine() -> getManager();

    $film = $em -> getRepository('TroiswaPublicBundle:Film') -> find($filmid); //Find pour récupérer un seul élément, et prend en argument l'id 


    $formFilm = $this -> createForm(new FilmType(), $film)
        -> add('Modifier', 'submit');


     $formFilm -> handleRequest($request) ; #Nouvelle version //on met les infos tapées dans le formulaire
                
                if($formFilm -> isValid())
                {
                    $film -> upload();

                    $em = $this -> getDoctrine() -> getManager();
                    $em -> persist ($film); #reconnait l'objet
                    $em -> flush(); #sauvegarde de l'objet
 
                    $session = $request -> getSession();
                    $session -> getFlashBag() -> add('info', 'Film modifié');

                    return $this -> redirect($this -> generateUrl('troiswa_public_admin_editer_film' , array( 'filmid' => $filmid) ));
                    #generateUrl prend en param l'identifiant de la root, et ici le paramètre acteur id

                }


      return $this -> render('TroiswaPublicBundle:Film:editer_film.html.twig', array('formFilm' => $formFilm -> createView()));


}






}


