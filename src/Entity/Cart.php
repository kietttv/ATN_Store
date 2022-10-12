<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=CartDetail::class, mappedBy="cart")
     */
    private $cartdetail;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function __construct()
    {
        $this->cartdetail = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, CartDetail>
     */
    public function getCartdetail(): Collection
    {
        return $this->cartdetail;
    }

    public function addCartdetail(CartDetail $cartdetail): self
    {
        if (!$this->cartdetail->contains($cartdetail)) {
            $this->cartdetail[] = $cartdetail;
            $cartdetail->setCart($this);
        }

        return $this;
    }

    public function removeCartdetail(CartDetail $cartdetail): self
    {
        if ($this->cartdetail->removeElement($cartdetail)) {
            // set the owning side to null (unless already changed)
            if ($cartdetail->getCart() === $this) {
                $cartdetail->setCart(null);
            }
        }

        return $this;
    }

}
