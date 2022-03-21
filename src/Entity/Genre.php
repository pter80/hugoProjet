<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity
 */
class Genre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

     /**
     * @var int
     *
     * @ORM\Column(name="moviedb_id", type="integer", nullable=true, unique=false)
     */
    private $moviedb_id;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false, unique=false)
     */
    private $name;
    
    /**
     *  Coté propriétaire
     * @ORM\ManyToOne(targetEntity="Emotion", inversedBy="genres")
     */
    private $emotion;

     /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="genres")
     */
    private $movies;
    
    public function __construct() {
        $this->movies = new \Doctrine\Common\Collections\ArrayCollection();
    
    }

    

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set moviedbId.
     *
     * @param int|null $moviedbId
     *
     * @return Genre
     */
    public function setMoviedbId($moviedbId = null)
    {
        $this->moviedb_id = $moviedbId;

        return $this;
    }

    /**
     * Get moviedbId.
     *
     * @return int|null
     */
    public function getMoviedbId()
    {
        return $this->moviedb_id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Genre
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add movie.
     *
     * @param \Entity\Movie $movie
     *
     * @return Genre
     */
    public function addMovie(\Entity\Movie $movie)
    {
        $this->movies[] = $movie;

        return $this;
    }

    /**
     * Remove movie.
     *
     * @param \Entity\Movie $movie
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMovie(\Entity\Movie $movie)
    {
        return $this->movies->removeElement($movie);
    }

    /**
     * Get movies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovies()
    {
        return $this->movies;
    }
}
