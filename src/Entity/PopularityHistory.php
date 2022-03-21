<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="popularity_history")
 * @ORM\Entity
 */
class PopularityHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="Entity\Movie")
     */
    private $movie;
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="popularity", type="integer", nullable=false, unique=false)
     */
    private $popularity;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="date", nullable=true, unique=false)
     */
    private $date;
    

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
     * Set popularity.
     *
     * @param int $popularity
     *
     * @return PopularityHistory
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get popularity.
     *
     * @return int
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Set movie.
     *
     * @param \Entity\Movie|null $movie
     *
     * @return PopularityHistory
     */
    public function setMovie(\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie.
     *
     * @return \Entity\Movie|null
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * Set date.
     *
     * @param \DateTime|null $date
     *
     * @return PopularityHistory
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }
}
