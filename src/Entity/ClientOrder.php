<?php

namespace App\Entity;

use App\Repository\ClientOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientOrderRepository::class)
 */
class ClientOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="clientOrders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity=ClientTable::class, inversedBy="clientOrders")
     */
    private $clientTable;

    /**
     * @ORM\ManyToMany(targetEntity=Dish::class, inversedBy="clientOrders")
     */
    private $dish;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixTotal;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $state;

    public function __construct()
    {
        $this->dish = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getClientTable(): ?ClientTable
    {
        return $this->clientTable;
    }

    public function setClientTable(?ClientTable $clientTable): self
    {
        $this->clientTable = $clientTable;

        return $this;
    }

    /**
     * @return Collection|Dish[]
     */
    public function getDish(): Collection
    {
        return $this->dish;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dish->contains($dish)) {
            $this->dish[] = $dish;
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        $this->dish->removeElement($dish);

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(?float $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
