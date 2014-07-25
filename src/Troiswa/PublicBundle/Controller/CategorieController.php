<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CategorieController extends Controller{

public function CategoriesAction(){

#Requete via doctrine
$em = $this -> getDoctrine() -> getManager();
#Exécution de la requête
$categories = $em -> getRepository('TroiswaPublicBundle:Categorie') -> findAll();

return $this->render('TroiswaPublicBundle:Categorie:categories.html.twig',array('categories' => $categories));


}






















}