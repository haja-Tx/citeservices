<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="stock")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Defectueux", mappedBy="stock", orphanRemoval=true)
     */
    private $defectueuses;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reste;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->defectueuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?int
    {
        /*if (is_null($this->products))
        {
            return $this->quantity;
        }
        else{
            $quantity_vendu = 0;
            foreach ($this->getProducts() as $product) {
             foreach ($product->getVentes() as $vente) {
                $quantity_vendu += $vente->getQuantity();
                }
            }
            return $this->quantity - $quantity_vendu;
        }*/
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setStock($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getStock() === $this) {
                $product->setStock(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Defectueux[]
     */
    public function getDefectueuses(): Collection
    {

        return $this->defectueuses;
    }

    public function addDefectueus(Defectueux $defectueus): self
    {
        if (!$this->defectueuses->contains($defectueus)) {
            $this->defectueuses[] = $defectueus;
            $defectueus->setStock($this);

        }

        return $this;
    }

    public function removeDefectueus(Defectueux $defectueus): self
    {
        if ($this->defectueuses->contains($defectueus)) {
            $this->defectueuses->removeElement($defectueus);
            // set the owning side to null (unless already changed)
            if ($defectueus->getStock() === $this) {
                $defectueus->setStock(null);
            }
        }

        return $this;
    }

    public function getReste(): ?int
    {
        
        return $this->reste;

        /*if (is_null($this->products))
        {
            return $this;
        }
        else{
            $quantity_vendu = 0;
            foreach ($this->getProducts() as $product) {
             foreach ($product->getVentes() as $vente) {
                $quantity_vendu += $vente->getQuantity();
                }
            }
            $quantity_defect=0;
            if (!is_null($this->defectueuses)) {
                foreach ($this->getDefectueuses() as $defecteux) {
                    $quantity_defect += $defecteux->getQuantity();
                }
            }

            return $this->quantity - $quantity_vendu - $quantity_defect;
        }*/
    }

    public function setReste(): self
    {
        /*$this->reste = $reste;*/
        $quantity_vendu = 0;
        $quantity_defect = 0;
        if (!is_null($this->products))
        {
           foreach ($this->getProducts() as $product) {
             foreach ($product->getVentes() as $vente) {
                $quantity_vendu += $vente->getQuantity();
                }
            }
        }
        if (!is_null($this->defectueuses)) {
            foreach ($this->getDefectueuses() as $defecteux) {
                $quantity_defect += $defecteux->getQuantity();
            }
        }
            
        
        $this->reste = $this->quantity - $quantity_vendu - $quantity_defect;
        return $this;
    }
}
