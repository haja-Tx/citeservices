<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VenteRepository")
 */
class Vente
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="vente")
     * @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $prix_total;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Facture", mappedBy="ventes")
     */
    private $factures;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $pu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vendor;


    public function __construct()
    {
        $this->date = new \DateTime(null, new \DateTimeZone('Africa/Nairobi'));
        $this->factures = new ArrayCollection();
        /*$this->vendor = $vendor;*/
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /*public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }*/

    public function setDate(): self
    {
        $this->date = new \DateTime(null, new \DateTimeZone('Africa/Nairobi'));

        return $this;
    }
    
    

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param Product $produit
     */
    public function getProduit(): ?Product
    {
        return $this->produit;
    }

    public function setProduit(?Product $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPrixTotal(): ?string
    {

        return $this->prix_total;
        
       /* if (is_null($this->produit))
        {
        return $this->prix_total;
        }
        else
        {
        return $this->produit->getPrix() * $this->quantity;
        }*/
        
    }

    public function setPrixTotal(string $prix_total): self
    {
        

        /*return $this;*/
        if (is_null($this->produit))
        {
            $this->prix_total = $prix_total;
            return $this;
        }
        else
        {
            
            $this->prix_total = round($this->produit->getPrix() * $this->quantity, -2);
            return $this;
        }
       
    }
    


    
    public function __toString()
    {
        if (!is_null($this->produit)) {
           return $this->getProduit()->getName().' x '.$this->getQuantity().' = '.$this->getPrixTotal();
        }
        else{
            return $this->id;
        }
        
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->addVente($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->contains($facture)) {
            $this->factures->removeElement($facture);
            $facture->removeVente($this);
        }

        return $this;
    }

    public function getPu(): ?string
    {
        return $this->pu;
    }

    public function setPu(?string $pu): self
    {
        if (is_null($this->produit))
        {
        $this->pu = $pu;
        return $this;
        }
        else{
            $this->pu = $this->produit->getPrix();
            return $this;
        }
        
    }

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(?string $vendor): self
    {
        
        $this->vendor = $vendor;
        return $this;
    }

}
