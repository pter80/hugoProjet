<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/*
"adult": false,
            "backdrop_path": "/o76ZDm8PS9791XiuieNB93UZcRV.jpg",
            "genre_ids": [
                27,
                28,
                878
            ],
            "id": 460458,
            "original_language": "en",
            "original_title": "Resident Evil: Welcome to Raccoon City",
            "overview": "Autrefois le siège en plein essor du géant pharmaceutique Umbrella Corporation, Raccoon City est aujourd'hui une ville à l'agonie. L'exode de la société a laissé la ville en friche... et un grand mal se prépare sous la surface. Lorsque celui-ci se déchaîne, les habitants de la ville sont à jamais... changés... et un petit groupe de survivants doit travailler ensemble pour découvrir la vérité sur Umbrella et survivre à la nuit.",
            "popularity": 1564.526,
            "poster_path": "/2kUS3XhbsKfTGdm99f8ZksLJ5RV.jpg",
            "release_date": "2021-11-24",
            "title": "Resident Evil : Bienvenue à Raccoon City",
            "video": false,
            "vote_average": 6.2,
            "vote_count": 1190
        },
*/

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity
 */
class Movie
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
     * @ORM\Column(name="moviedb_id", type="integer", nullable=false, unique=false)
     */
    private $moviedb_id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="release_date", type="string", nullable=true, unique=false)
     */
    private $release_date;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="original_title", type="string", nullable=false, unique=false)
     */
    private $original_title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false, unique=false)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="original_language", type="string", nullable=false, unique=false)
     */
    private $original_language;
    
    /**
     * @var text
     *
     * @ORM\Column(name="overview", type="text", nullable=false, unique=false)
     */
    private $overview;
    
    /**
     * @var int
     *
     * @ORM\Column(name="popularity", type="integer", nullable=false, unique=false)
     */
    private $popularity;
    
    /**
     * @var string
     *
     * @ORM\Column(name="poster_path", type="string", nullable=true, unique=false, options={"default" = "no poster"})
     */
    private $poster_path;
    
    /**
     * @var float
     *
     * @ORM\Column(name="vote_average", type="float", nullable=false, unique=false)
     */
    private $vote_average;
    
    /**
     * @var array
     *
     * @ORM\Column(name="genre_ids", type="array", nullable=true, unique=false)
     */
    private $genre_ids;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="movies", orphanRemoval=true, cascade={"persist"})
     */
    private $genres;
    
    
    public function __construct() {
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param int $moviedbId
     *
     * @return Movie
     */
    public function setMoviedbId($moviedbId)
    {
        $this->moviedb_id = $moviedbId;

        return $this;
    }

    /**
     * Get moviedbId.
     *
     * @return int
     */
    public function getMoviedbId()
    {
        return $this->moviedb_id;
    }

    /**
     * Set originalTitle.
     *
     * @param string $originalTitle
     *
     * @return Movie
     */
    public function setOriginalTitle($originalTitle)
    {
        $this->original_title = $originalTitle;

        return $this;
    }

    /**
     * Get originalTitle.
     *
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->original_title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set originalLanguage.
     *
     * @param string $originalLanguage
     *
     * @return Movie
     */
    public function setOriginalLanguage($originalLanguage)
    {
        $this->original_language = $originalLanguage;

        return $this;
    }

    /**
     * Get originalLanguage.
     *
     * @return string
     */
    public function getOriginalLanguage()
    {
        return $this->original_language;
    }

    /**
     * Set overview.
     *
     * @param string $overview
     *
     * @return Movie
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview.
     *
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Set popularity.
     *
     * @param int $popularity
     *
     * @return Movie
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
     * Set posterPath.
     *
     * @param string $posterPath
     *
     * @return Movie
     */
    public function setPosterPath($posterPath)
    {
        $this->poster_path = $posterPath;

        return $this;
    }

    /**
     * Get posterPath.
     *
     * @return string
     */
    public function getPosterPath()
    {
        return $this->poster_path;
    }

    /**
     * Set voteAverage.
     *
     * @param float $voteAverage
     *
     * @return Movie
     */
    public function setVoteAverage($voteAverage)
    {
        $this->vote_average = $voteAverage;

        return $this;
    }

    /**
     * Get voteAverage.
     *
     * @return float
     */
    public function getVoteAverage()
    {
        return $this->vote_average;
    }

    /**
     * Set releaseDate.
     *
     * @param \DateTime $releaseDate
     *
     * @return Movie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->release_date = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate.
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }


    /**
     * Add genre.
     *
     * @param \Entity\Genre $genre
     *
     * @return Movie
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


    public function getMyGenreIds()
    {
        $ids=[];
        foreach ($this->genres as $genre){
            $ids[]=$genre->getMoviedbId();
            
        }
        return $ids;
    }

    /**
     * Set genreIds.
     *
     * @param array|null $genreIds
     *
     * @return Movie
     */
    public function setGenreIds($genreIds = null)
    {
        $this->genre_ids = $genreIds;

        return $this;
    }

    /**
     * Get genreIds.
     *
     * @return array|null
     */
    public function getGenreIds()
    {
        return $this->genre_ids;
    }
}
