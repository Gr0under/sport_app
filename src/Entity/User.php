<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email", "pseudo"},
 *     message="Cet email est déjà utilisé"
 *   )
 */
class User implements UserInterface
{
    const GENDERS = ['female', 'male', 'other'];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     * @Assert\NotBlank(message="Veuillez saisir un email valide", groups={"registration"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $pseudo;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Date
     * @var string A "d/m/Y" formatted value
     */
    private $birthdate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Votre code postal doit comporter 5 chiffres uniquement",
     *      maxMessage = "Votre code postal doit comporter 5 chiffres uniquement",
     *      allowEmptyString = false
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Choice(choices=User::GENDERS)
     */
    private $gender;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=0, groups={"description"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SportEvent", mappedBy="organiser", orphanRemoval=true)
     */
    private $sportEventsOrganiser;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SportEvent", mappedBy="players")
     */
    private $sportEventsAsPlayer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SportCategory", inversedBy="players")
     */
    private $sports;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventWallMessage", mappedBy="author")
     */
    private $eventWallMessages;

 

    public function __construct()
    {
        $this->sportEventsOrganiser = new ArrayCollection();
        $this->sportEventsAsPlayer = new ArrayCollection();
        $this->sports = new ArrayCollection();
        $this->eventWallMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAddress(): ?int
    {
        return $this->address;
    }

    public function setAddress(?int $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|SportEvent[]
     */
    public function getSportEventsOrganiser(): Collection
    {
        return $this->sportEventsOrganiser;
    }

    public function addSportEventsOrganiser(SportEvent $sportEventsOrganiser): self
    {
        if (!$this->sportEventsOrganiser->contains($sportEventsOrganiser)) {
            $this->sportEventsOrganiser[] = $sportEventsOrganiser;
            $sportEventsOrganiser->setOrganiser($this);
        }

        return $this;
    }

    public function removeSportEventsOrganiser(SportEvent $sportEventsOrganiser): self
    {
        if ($this->sportEventsOrganiser->contains($sportEventsOrganiser)) {
            $this->sportEventsOrganiser->removeElement($sportEventsOrganiser);
            // set the owning side to null (unless already changed)
            if ($sportEventsOrganiser->getOrganiser() === $this) {
                $sportEventsOrganiser->setOrganiser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SportEvent[]
     */
    public function getSportEventsAsPlayer(): Collection
    {
        return $this->sportEventsAsPlayer;
    }

    public function addSportEventsAsPlayer(SportEvent $sportEventsAsPlayer): self
    {
        if (!$this->sportEventsAsPlayer->contains($sportEventsAsPlayer)) {
            $this->sportEventsAsPlayer[] = $sportEventsAsPlayer;
            $sportEventsAsPlayer->addPlayer($this);
        }

        return $this;
    }

    public function removeSportEventsAsPlayer(SportEvent $sportEventsAsPlayer): self
    {
        if ($this->sportEventsAsPlayer->contains($sportEventsAsPlayer)) {
            $this->sportEventsAsPlayer->removeElement($sportEventsAsPlayer);
            $sportEventsAsPlayer->removePlayer($this);
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|SportCategory[]
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(SportCategory $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
        }

        return $this;
    }

    public function removeSport(SportCategory $sport): self
    {
        if ($this->sports->contains($sport)) {
            $this->sports->removeElement($sport);
        }

        return $this;
    }

    /**
     * @return Collection|EventWallMessage[]
     */
    public function getEventWallMessages(): Collection
    {
        return $this->eventWallMessages;
    }

    public function addEventWallMessage(EventWallMessage $eventWallMessage): self
    {
        if (!$this->eventWallMessages->contains($eventWallMessage)) {
            $this->eventWallMessages[] = $eventWallMessage;
            $eventWallMessage->setAuthor($this);
        }

        return $this;
    }

    public function removeEventWallMessage(EventWallMessage $eventWallMessage): self
    {
        if ($this->eventWallMessages->contains($eventWallMessage)) {
            $this->eventWallMessages->removeElement($eventWallMessage);
            // set the owning side to null (unless already changed)
            if ($eventWallMessage->getAuthor() === $this) {
                $eventWallMessage->setAuthor(null);
            }
        }

        return $this;
    }

}
