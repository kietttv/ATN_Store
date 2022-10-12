<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailRepository::class)
 */
class OrderDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $OderProQuan;

    /**
     * @ORM\Column(type="integer")
     */
    private $Price;

    /**
     * @ORM\Column(type="integer")
     */
    private $Total;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="Orderdetailid")
     */
    private $Orderid;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="Orderdetailid")
     */
    private $Productid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOderProQuan(): ?int
    {
        return $this->OderProQuan;
    }

    public function setOderProQuan(int $OderProQuan): self
    {
        $this->OderProQuan = $OderProQuan;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->Total;
    }

    public function setTotal(int $Total): self
    {
        $this->Total = $Total;

        return $this;
    }

    public function getOrderid(): ?Order
    {
        return $this->Orderid;
    }

    public function setOrderid(?Order $Orderid): self
    {
        $this->Orderid = $Orderid;

        return $this;
    }

    public function getProductid(): ?Product
    {
        return $this->Productid;
    }

    public function setProductid(?Product $Productid): self
    {
        $this->Productid = $Productid;

        return $this;
    }
}
