<?php

namespace Troiswa\PublicBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acteur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\ActeurRepository")
 */
class Acteur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="text")
     * @ASSERT\NotBlank(message="veuillez rentrer un prénom");
     * @ASSERT\Length(min = 2, minMessage="veuillez rentrer un prénom  plus long");
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="text")
     * @ASSERT\NotBlank(message="Veuillez rentrer un nom");
     * @ASSERT\Length(min = 3, minMessage="veuillez rentrer un nom  plus long");
        */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     * @ASSERT\NotBlank(message="Veuillez rentrer une date de naissance");
     * @ASSERT\Date(message="Veuillez rentrer une date de naissance valide");
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=3)
     * @ASSERT\NotBlank(message="Veuillez rentrer un sexe");
     * @ASSERT\Choice(choices = {"F" , "M"}, message="Veuillez rentrer un sexe valide");
    */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=3)
     * @ASSERT\NotBlank(message="Veuillez rentrer une nationalité");
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="biographie", type="text")
     * @ASSERT\NotBlank(message="Veuillez rentrer une biographie");
     */
    private $biographie;

 /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


    /**
     * @ASSERT\NotBlank(message="Veuillez ajouter un fichier");
     * @ASSERT\Image(
     *     maxSize = "1000k",
     *     maxSizeMessage = "Le fichier est trop lourd, choisir un fichier de moins d'1 M",
     *     mimeTypes = {"image/png", "image/jpeg", "image/pjpeg"},
     *     mimeTypesMessage = "Choisissez un fichier image valide"
     * )
     */
    private $fichier;

    //ORM: lié à la base de donnée - pas d'ORM: pas lié à la base de données



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Acteur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Acteur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Acteur
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Acteur
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     * @return Acteur
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set biographie
     *
     * @param string $biographie
     * @return Acteur
     */
    public function setBiographie($biographie)
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get biographie
     *
     * @return string 
     */
    public function getBiographie()
    {
        return $this->biographie;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Acteur
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }




    /**
     * Set fichier
     *
     * @param string $fichier
     * @return Acteur
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return string 
     */
    public function getFichier()
    {
        return $this->fichier;
    }



 

    public function upload(){
            if(null === $this -> fichier){

                return;

            }

            //Pour renommer chaque fichier uploadé avec nom _prenom.extension
            $nameFile = $this -> prenom .'_'. $this -> nom . '_'. uniqid() . '.' . $this -> fichier -> guessExtension ();

            $this -> fichier -> move($this -> getUploadBootDir(), $nameFile); //pour indiquer le chemin où on veut uploader - move (lieu, nom)
            $this-> image = $nameFile; //Pour reprendre le nom initial du fichier
            

            /* Ancienne version oùon prenait le nom original
            $this -> fichier -> move($this -> getUploadBootDir(), $this -> fichier -> getClientOriginalName()); //pour indiquer le chemin où on veut uploader - move (lieu, nom)
            $this-> image = $this -> fichier -> getClientOriginalName(); //Pour reprendre le nom initial du fichier
            */


    }


   public function getUploadDir(){

        return "uploads/Acteurs";

    }




    public function getWebPath(){

        if(null === $this -> image){
            return null;
        }

        return $this -> getUploadDir() . "/". $this -> image;
    }





    public function getUploadBootDir(){

        return __DIR__ . '/../../../../web/'. $this -> getUploadDir() ; //symfony crée le fichier upload

    }


}


