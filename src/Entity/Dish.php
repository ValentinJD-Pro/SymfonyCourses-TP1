<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DishRepository::class)
 */
class Dish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $Name;

    /**
     * @ORM\Column(type="integer")
     */
    private $Calories;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Type(type={"int", "float"})
     */
    private $Price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "Must be at least {{ limit }} characters long",
     *      maxMessage = "Cannot be longer than {{ limit }} characters"
     * )
     */
    private $Description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Sticky;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @Assert\NotBlank()
     */
    private $Category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $User;

    /**
     * @ORM\ManyToMany(targetEntity=Allergen::class, mappedBy="Dish")
     */
    private $allergens;

    /**
     * @ORM\ManyToMany(targetEntity=ClientOrder::class, mappedBy="dish")
     */
    private $clientOrders;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
        $this->clientOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->Calories;
    }

    public function setCalories(int $Calories): self
    {
        $this->Calories = $Calories;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getSticky(): ?bool
    {
        return $this->Sticky;
    }

    public function setSticky(bool $Sticky): self
    {
        $this->Sticky = $Sticky;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|Allergen[]
     */
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergen $allergen): self
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens[] = $allergen;
            $allergen->addDish($this);
        }

        return $this;
    }

    public function removeAllergen(Allergen $allergen): self
    {
        if ($this->allergens->removeElement($allergen)) {
            $allergen->removeDish($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->Name;
    }

    /**
     * @return Collection|ClientOrder[]
     */
    public function getClientOrders(): Collection
    {
        return $this->clientOrders;
    }

    public function addClientOrder(ClientOrder $clientOrder): self
    {
        if (!$this->clientOrders->contains($clientOrder)) {
            $this->clientOrders[] = $clientOrder;
            $clientOrder->addDish($this);
        }

        return $this;
    }

    public function removeClientOrder(ClientOrder $clientOrder): self
    {
        if ($this->clientOrders->removeElement($clientOrder)) {
            $clientOrder->removeDish($this);
        }

        return $this;
    }
}
