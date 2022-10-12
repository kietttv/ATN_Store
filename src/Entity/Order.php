<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Orderdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Deliverydate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Address;

    /**
     * @ORM\Column(type="integer")
     */
    private $Payment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="Orderid")
     */
    private $Orderdetailid;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderid")
     */
    private $user;

    public function __construct()
    {
        $this->Orderdetailid = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderdate(): ?\DateTimeInterface
    {
        return $this->Orderdate;
    }

    public function setOrderdate(\DateTimeInterface $Orderdate): self
    {
        $this->Orderdate = $Orderdate;

        return $this;
    }

    public function getDeliverydate(): ?\DateTimeInterface
    {
        return $this->Deliverydate;
    }

    public function setDeliverydate(?\DateTimeInterface $Deliverydate): self
    {
        $this->Deliverydate = $Deliverydate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getPayment(): ?int
    {
        return $this->Payment;
    }

    public function setPayment(int $Payment): self
    {
        $this->Payment = $Payment;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }


    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderdetailid(): Collection
    {
        return $this->Orderdetailid;
    }

    public function addOrderdetailid(OrderDetail $orderdetailid): self
    {
        if (!$this->Orderdetailid->contains($orderdetailid)) {
            $this->Orderdetailid[] = $orderdetailid;
            $orderdetailid->setOrderid($this);
        }

        return $this;
    }

    public function removeOrderdetailid(OrderDetail $orderdetailid): self
    {
        if ($this->Orderdetailid->removeElement($orderdetailid)) {
            // set the owning side to null (unless already changed)
            if ($orderdetailid->getOrderid() === $this) {
                $orderdetailid->setOrderid(null);
            }
        }

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

}
