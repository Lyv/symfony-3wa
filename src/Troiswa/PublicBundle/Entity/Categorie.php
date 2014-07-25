<?php

namespace Troiswa\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\PublicBundle\Entity\CategorieRepository")
 */
class Categorie
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
     * @ORM\Column(name="Titre", type="string", length=255)
     */
    private $titre;


    #Relation One to Many avec la categorie: une cat -> plusieurs films
    # La clé étrangère est stockée dans film, du coup il faut préciser le champs pour faire la liaison (categorie)

    /**
    *@ORM\OneToMany(targetEntity = "Troiswa\PublicBundle\Entity\Film", mappedBy = "categorie")
    */
    private $films;


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
     * Set titre
     *
     * @param string $titre
     * @return Categorie
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->films = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add films
     *
     * @param \Troiswa\PublicBundle\Entity\Film $films
     * @return Categorie
     */
    public function addFilm(\Troiswa\PublicBundle\Entity\Film $films)
    {
        $this->films[] = $films;

        return $this;
    }

    /**
     * Remove films
     *
     * @param \Troiswa\PublicBundle\Entity\Film $films
     */
    public function removeFilm(\Troiswa\PublicBundle\Entity\Film $films)
    {
        $this->films->removeElement($films);
    }

    /**
     * Get films
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilms()
    {
        return $this->films;
    }
}
