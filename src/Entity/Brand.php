<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Brandname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Branddes;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="Brandid")
     */
    private $Productid;

    /**
     * @ORM\Column(type="integer")
     */
    private $Status;

    public function __construct()
    {
        $this->Productid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandname(): ?string
    {
        return $this->Brandname;
    }

    public function setBrandname(string $Brandname): self
    {
        $this->Brandname = $Brandname;

        return $this;
    }

    public function getBranddes(): ?string
    {
        return $this->Branddes;
    }

    public function setBranddes(string $Branddes): self
    {
        $this->Branddes = $Branddes;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductid(): Collection
    {
        return $this->Productid;
    }

    public function addProductid(Product $productid): self
    {
        if (!$this->Productid->contains($productid)) {
            $this->Productid[] = $productid;
            $productid->setBrandid($this);
        }

        return $this;
    }

    public function removeProductid(Product $productid): self
    {
        if ($this->Productid->removeElement($productid)) {
            // set the owning side to null (unless already changed)
            if ($productid->getBrandid() === $this) {
                $productid->setBrandid(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->Status;
    }

    public function setStatus(int $Status): self
    {
        $this->Status = $Status;

        return $this;
    }
}
