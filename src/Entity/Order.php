<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @ORM\HasLifecycleCallbacks()
 */
class Order implements OrderInterface
{

    use TimeStampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $total;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=100, nullable=true,options={"default":self::ORDER_RECEIVED})
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="orderDetails",cascade={"persist","remove"})
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity=ShippingDetails::class, mappedBy="orderDetails",cascade={"persist","remove"})
     */
    private $shipping;

    public function __construct()
    {
        $this->state = self::ORDER_RECEIVED;
        $this->product = new ArrayCollection();
        $this->shipping = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = ($state === null) ? self::ORDER_RECEIVED : $state;
        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setOrderDetails($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getOrderDetails() === $this) {
                $product->setOrderDetails(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShippingDetails[]
     */
    public function getShipping(): Collection
    {
        return $this->shipping;
    }

    public function addShipping(ShippingDetails $shipping): self
    {
        if (!$this->shipping->contains($shipping)) {
            $this->shipping[] = $shipping;
            $shipping->setOrderDetails($this);
        }

        return $this;
    }

    public function removeShipping(ShippingDetails $shipping): self
    {
        if ($this->shipping->removeElement($shipping)) {
            // set the owning side to null (unless already changed)
            if ($shipping->getOrderDetails() === $this) {
                $shipping->setOrderDetails(null);
            }
        }

        return $this;
    }
}
