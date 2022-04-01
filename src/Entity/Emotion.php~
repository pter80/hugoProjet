<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Entity\Genre;

/**
 * Emotion
 *
 * @ORM\Table(name="emotion")
 * @ORM\Entity
 */
class Emotion
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false, unique=false)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="emoji", type="string", nullable=false, unique=false)
     */
    private $emoji;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="Genre", mappedBy="emotion")
     *
     */
    private $genres;
    
    public function __construct() {
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function idsGenres() {
        $idsGenre=[];
        foreach ($this->getGenres() as $genre){
            $idsGenre[]=$genre->getId();
        }   
        return $idsGenre;
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
     * Set name.
     *
     * @param string $name
     *
     * @return Emotion
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
     * Set emoji.
     *
     * @param string $emoji
     *
     * @return Emotion
     */
    public function setEmoji($emoji)
    {
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * Get emoji.
     *
     * @return string
     */
    public function getEmoji()
    {
        return $this->emoji;
    }

    /**
     * Add genre.
     *
     * @param \Entity\Genre $genre
     *
     * @return Emotion
     */
    public function addGenre(\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre.
     *
     * @param \Entity\Genre $genre
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeGenre(\Entity\Genre $genre)
    {
        return $this->genres->removeElement($genre);
    }

    /**
     * Get genres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }
}
