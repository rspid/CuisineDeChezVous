<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[Assert\EqualTo(propertyPath: "password", message: "Vous n'avez pas tapé le même mot de passe")]
    public $confirm_password;

    #[ORM\Column(type: 'string', length: 255)]
    private $pseudo;

    #[ORM\Column(type: 'datetime')]
    private $dateInscription;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commentaire::class)]
    private $commentaires;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Recette::class)]
    private $recettes;

    #[ORM\ManyToMany(targetEntity: Recette::class, inversedBy: 'userSauvegarde')]
    private $recetteSauvegarde;

    #[ORM\ManyToOne(targetEntity: Recette::class, inversedBy: 'userFavoris')]
    private $recetteFavoris;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RecetteNote::class)]
    private $notesAttribue;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->recettes = new ArrayCollection();
        $this->recetteSauvegarde = new ArrayCollection();
        $this->notesAttribue = new ArrayCollection();
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
    public function getUserIdentifier(): string
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

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
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recette[]
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): self
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes[] = $recette;
            $recette->setCreateur($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): self
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getCreateur() === $this) {
                $recette->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recette[]
     */
    public function getRecetteSauvegarde(): Collection
    {
        return $this->recetteSauvegarde;
    }

    public function addRecetteSauvegarde(Recette $recetteSauvegarde): self
    {
        if (!$this->recetteSauvegarde->contains($recetteSauvegarde)) {
            $this->recetteSauvegarde[] = $recetteSauvegarde;
        }

        return $this;
    }

    public function removeRecetteSauvegarde(Recette $recetteSauvegarde): self
    {
        $this->recetteSauvegarde->removeElement($recetteSauvegarde);

        return $this;
    }

    public function getRecetteFavoris(): ?Recette
    {
        return $this->recetteFavoris;
    }

    public function setRecetteFavoris(?Recette $recetteFavoris): self
    {
        $this->recetteFavoris = $recetteFavoris;

        return $this;
    }

    /**
     * @return Collection|RecetteNote[]
     */
    public function getNotesAttribue(): Collection
    {
        return $this->notesAttribue;
    }

    public function addNotesAttribue(RecetteNote $notesAttribue): self
    {
        if (!$this->notesAttribue->contains($notesAttribue)) {
            $this->notesAttribue[] = $notesAttribue;
            $notesAttribue->setUser($this);
        }

        return $this;
    }

    public function removeNotesAttribue(RecetteNote $notesAttribue): self
    {
        if ($this->notesAttribue->removeElement($notesAttribue)) {
            // set the owning side to null (unless already changed)
            if ($notesAttribue->getUser() === $this) {
                $notesAttribue->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
