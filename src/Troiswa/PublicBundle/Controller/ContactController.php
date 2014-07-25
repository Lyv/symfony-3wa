<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\httpfoundation\request;


use Symfony\Component\Validator\Constraints as Assert;

//Pas nécessaire de lier le formulaire à un objet, sauf si on voulait enregistrer les mesages reçus.
//pas de formType étant donné que pas de classe


class ContactController extends Controller{

public function contactAction(Request $request){
  

    $formContact = $this ->createFormBuilder()
                  -> add('name', 'text',
                    array(
                      'constraints' => new Assert\NotBlank(
                        array(
                          'message' => 'Veuillez rentrer un nom'
                          )
                        )
                      )
                    )


                  -> add('email', null,  
                    array(
                      'constraints' => 
                      array(
                        new Assert\NotBlank(), 
                        new Assert\Email(
                          array(
                            'message' => "'{{ email }}' n'est pas un email valide.")
                          ) 
                        )
                      )
                    )

                  -> add ('phone', null, 
                    array(
                      'constraints' => new Assert\Regex(
                        array(
                          'pattern' => '^\+?\s*(\d+\s?){8,}$', //Regex numero telephone    
                          'match' => false,
                          'message' => "Un numero de telephone ne peut contenir une lettre"
                      )
                     ) 
                    )
                  )
                  -> add ('message', 'textarea', 
                    array(
                      'constraints' => 
                      array(
                      new Assert\NotBlank(
                        array(
                          "message" => "Veuillez rentrer un texte"
                          )
                        ),
                      new Assert\Length(
                        array(
                          'max' => "500" , 
                          "maxMessage" => 'Le message doit faire au plus 500 caracteres'
                            ) 
                          )
                      )
                    )
                    )
                        
                  -> add ('envoyer', 'submit') 

                  -> getForm();


    $formContact -> handleRequest($request) ; 
                
                if($formContact -> isValid())
                {


                  $email = $formContact -> get('email') -> getData();
                  $name = $formContact -> get('name') -> getData();
                  $mail = \Swift_Message::newInstance()

                    -> setSubject("Formulaire de contact")
                    -> setFrom($email)
                    -> setTo("lyvia.cairo@gmail.com")
                    -> setBody($this -> renderView('TroiswaPublicBundle:Mail:contacttemplate.html.twig', array('name' => $name)));

                  
                    $session = $request -> getSession();
                    $session -> getFlashBag() -> add('msg', 'Message envoyé');

                    return $this -> redirect($this -> generateUrl('troiswa_public_contact'));
                    #generateUrl prend en param l'identifiant de la root, et ici le paramètre acteur id

                    $this -> get('mailer') -> send($message);
                }


      return $this -> render('TroiswaPublicBundle:Contact:contact.html.twig', array('formContact' => $formContact -> createView()));


}



}