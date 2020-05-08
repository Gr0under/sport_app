<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportEventRepository")
 */
class SportEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $organiser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location_dpt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location_city;

    /**
     * @ORM\Column(type="text")
     */
    private $location_address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $location_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $player;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $level_description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $material;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $price_description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $time_start;

    /**
     * @ORM\Column(type="time")
     */
    private $time_end;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportCategory", inversedBy="sportEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sportCategory;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $other_attributes = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $max_players;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOrganiser(): ?string
    {
        return $this->organiser;
    }

    public function setOrganiser(string $organiser): self
    {
        $this->organiser = $organiser;

        return $this;
    }


    public function getLocationDpt(): ?string
    {
        return $this->location_dpt;
    }

    public function setLocationDpt(string $location_dpt): self
    {
        $this->location_dpt = $location_dpt;

        return $this;
    }

    public function getLocationCity(): ?string
    {
        return $this->location_city;
    }

    public function setLocationCity(string $location_city): self
    {
        $this->location_city = $location_city;

        return $this;
    }

    public function getLocationAddress(): ?string
    {
        return $this->location_address;
    }

    public function setLocationAddress(string $location_address): self
    {
        $this->location_address = $location_address;

        return $this;
    }

    public function getLocationDescription(): ?string
    {
        return $this->location_description;
    }

    public function setLocationDescription(?string $location_description): self
    {
        $this->location_description = $location_description;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function setPlayer(string $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLevelDescription(): ?string
    {
        return $this->level_description;
    }

    public function setLevelDescription(string $level_description): self
    {
        $this->level_description = $level_description;

        return $this;
    }

    public function getMaterial(): ?array
    {
        return $this->material;
    }

    public function setMaterial(array $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getPriceDescription(): ?string
    {
        return $this->price_description;
    }

    public function setPriceDescription(string $price_description): self
    {
        $this->price_description = $price_description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->time_start;
    }

    public function setTimeStart(\DateTimeInterface $time_start): self
    {
        $this->time_start = $time_start;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->time_end;
    }

    public function setTimeEnd(\DateTimeInterface $time_end): self
    {
        $this->time_end = $time_end;

        return $this;
    }

    
    public function getSportCategory(): ?SportCategory
    {
        return $this->sportCategory;
    }

    public function setSportCategory(?SportCategory $sportCategory): self
    {
        $this->sportCategory = $sportCategory;

        return $this;
    }

    public function getOtherAttributes(): ?array
    {
        return $this->other_attributes;
    }

    public function setOtherAttributes(?array $other_attributes): self
    {
        $this->other_attributes = $other_attributes;

        return $this;
    }

    public function getMaxPlayers(): ?int
    {
        return $this->max_players;
    }

    public function setMaxPlayers(int $max_players): self
    {
        $this->max_players = $max_players;

        return $this;
    }

}
