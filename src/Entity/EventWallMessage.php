<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventWallMessageRepository")
 */
class EventWallMessage
{
    use TimestampableEntity; 

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="eventWallMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(max=940)
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportEvent", inversedBy="eventWallMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPin(): ?bool
    {
        return $this->pin;
    }

    public function setPin(bool $pin): self
    {
        $this->pin = $pin;

        return $this;
    }

    public function getEvent(): ?SportEvent
    {
        return $this->event;
    }

    public function setEvent(?SportEvent $event): self
    {
        $this->event = $event;

        return $this;
    }

}
