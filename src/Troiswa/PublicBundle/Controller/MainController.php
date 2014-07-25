<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class MainController extends Controller
{
    public function indexAction()
    {
        
        $em = $this -> getDoctrine() -> getManager();
        $allFilmsByCategorie = $em -> getRepository('TroiswaPublicBundle:Film') -> getNbFilmByCategorie();


        return $this->render('TroiswaPublicBundle:Main:index.html.twig', array('allFilmsByCategorie' => $allFilmsByCategorie ));

        #render: 2 paramètre
        #On a changé default par main
    }


    public function bonjourAction(){
    	return $this->render('TroiswaPublicBundle:Main:bonjour.html.twig');
    }


    public function ageAction($number){
    #Attention, nom entre parenthèses doit etre pareil que dans routing
    	return $this->render('TroiswaPublicBundle:Main:age.html.twig', array('mon_age' => $number ));
    #Envoyer des infos dans la vue - tableau associatif

    }


    public function competencesAction(){
    #Attention, nom entre parenthèses doit etre pareil que dans routing
        
        $competences = array(
            'PHP' => array("note"=> 7,"couleur" => '#00a1ff'),
            'MYSQL' => array("note"=> 6,"couleur" => '#66CC66'),
            'CSS' => array("note"=> 8,"couleur" => '#efb569'),
            'HTML' => array("note"=> 7,"couleur" => '#cc66c1'),
            );
        return $this->render('TroiswaPublicBundle:Main:competences.html.twig', array('competences' => $competences ));
    #Envoyer des infos dans la vue - tableau associatif

    }


}
    
   