<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 50)]
    private $difficulte;

    #[ORM\Column(type: 'string', length: 50)]
    private $prix;

    #[ORM\Column(type: 'integer')]
    private $portions;

    #[ORM\Column(type: 'text', nullable: true)]
    private $histoire;

    #[ORM\Column(type: 'date')]
    private $datePublication;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomImage;

    #[ORM\Column(type: 'text', nullable: true)]
    private $astuce;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recettes')]
    #[ORM\JoinColumn(nullable: false)]
    private $createur;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'recetteSauvegarde')]
    private $userSauvegarde;

    #[ORM\OneToMany(mappedBy: 'recetteFavoris', targetEntity: User::class)]
    private $userFavoris;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: RecetteNote::class)]
    private $notes;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'recettes')]
    private $categories;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'recettes')]
    private $ingredients;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Etape::class)]
    private $etapes;

    #[ORM\ManyToMany(targetEntity: Option::class, inversedBy: 'recettes')]
    private $options;

    #[ORM\Column(type: 'time')]
    private $tempsPreparation;

    #[ORM\Column(type: 'time')]
    private $tempsCuisson;

    #[ORM\Column(type: 'time')]
    private $tempsRepos;

    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: 'recettes')]
    private $region;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Commentaire::class)]
    private $commentaires;

    public function __construct()
    {
        $this->userSauvegarde = new ArrayCollection();
        $this->userFavoris = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->etapes = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }


    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPortions(): ?int
    {
        return $this->portions;
    }

    public function setPortions(int $portions): self
    {
        $this->portions = $portions;

        return $this;
    }

    public function getHistoire(): ?string
    {
        return $this->histoire;
    }

    public function setHistoire(?string $histoire): self
    {
        $this->histoire = $histoire;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getNomImage(): ?string
    {
        return $this->nomImage;
    }

    public function setNomImage(string $nomImage): self
    {
        $this->nomImage = $nomImage;

        return $this;
    }

    public function getAstuce(): ?string
    {
        return $this->astuce;
    }

    public function setAstuce(?string $astuce): self
    {
        $this->astuce = $astuce;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserSauvegarde(): Collection
    {
        return $this->userSauvegarde;
    }

    public function addUserSauvegarde(User $userSauvegarde): self
    {
        if (!$this->userSauvegarde->contains($userSauvegarde)) {
            $this->userSauvegarde[] = $userSauvegarde;
            $userSauvegarde->addRecetteSauvegarde($this);
        }

        return $this;
    }

    public function removeUserSauvegarde(User $userSauvegarde): self
    {
        if ($this->userSauvegarde->removeElement($userSauvegarde)) {
            $userSauvegarde->removeRecetteSauvegarde($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserFavoris(): Collection
    {
        return $this->userFavoris;
    }

    public function addUserFavori(User $userFavori): self
    {
        if (!$this->userFavoris->contains($userFavori)) {
            $this->userFavoris[] = $userFavori;
            $userFavori->setRecetteFavoris($this);
        }

        return $this;
    }

    public function removeUserFavori(User $userFavori): self
    {
        if ($this->userFavoris->removeElement($userFavori)) {
            // set the owning side to null (unless already changed)
            if ($userFavori->getRecetteFavoris() === $this) {
                $userFavori->setRecetteFavoris(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RecetteNote[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(RecetteNote $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setRecette($this);
        }

        return $this;
    }

    public function removeNote(RecetteNote $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getRecette() === $this) {
                $note->setRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * @return Collection|Etape[]
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes[] = $etape;
            $etape->setRecette($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getRecette() === $this) {
                $etape->setRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getTempsPreparation(): ?\DateTimeInterface
    {
        return $this->tempsPreparation;
    }

    public function setTempsPreparation(\DateTimeInterface $tempsPreparation): self
    {
        $this->tempsPreparation = $tempsPreparation;

        return $this;
    }

    public function getTempsCuisson(): ?\DateTimeInterface
    {
        return $this->tempsCuisson;
    }

    public function setTempsCuisson(\DateTimeInterface $tempsCuisson): self
    {
        $this->tempsCuisson = $tempsCuisson;

        return $this;
    }

    public function getTempsRepos(): ?\DateTimeInterface
    {
        return $this->tempsRepos;
    }

    public function setTempsRepos(\DateTimeInterface $tempsRepos): self
    {
        $this->tempsRepos = $tempsRepos;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

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
            $commentaire->setRecette($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getRecette() === $this) {
                $commentaire->setRecette(null);
            }
        }

        return $this;
    }

    public function isNoteByUser(User $user): bool
    {
        foreach ($this->notes as $note) {
            if ($note->getUser() === $user) return true;
        }

        return false;
    }
}
