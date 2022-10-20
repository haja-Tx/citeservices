<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Vente", inversedBy="factures", cascade={"persist"})
     */
    private $ventes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Connection", inversedBy="factures")
     */
    private $connexion;

    

    public function __construct()
    {
        $this->date = new \DateTime(null, new \DateTimeZone('Africa/Nairobi'));
        $this->ventes = new ArrayCollection();
        $this->connexion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        /*$this->date = $date;*/
        $this->date = new \DateTime(null, new \DateTimeZone('Africa/Nairobi'));

        return $this;
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

    /**
     * @return Collection|Vente[]
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }

    public function addVente(Vente $vente): self
    {
        if (!$this->ventes->contains($vente)) {
            $this->ventes[] = $vente;
        }

        return $this;
    }

    public function removeVente(Vente $vente): self
    {
        if ($this->ventes->contains($vente)) {
            $this->ventes->removeElement($vente);
        }

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
       /* if (is_null($this->getVentes())) {
            return $this->total;
        }
        else{
            $total=0;
            foreach ($this->getVentes() as $vente) {
                $total += $vente->getPrixTotal();
            }
            return $total;
        }*/
    }

    public function setTotal(string $total): self
    {
        /*$this->total = $total;

        return $this;*/
        /*if (is_null($this->getVentes())) {
            return $this;
        }
        else{*/
            $total=0;
            foreach ($this->getVentes() as $vente) {
                $total += $vente->getPrixTotal();

            }
            foreach ($this->getConnexion() as $connexion) {
                    $total += $connexion->getMontant();
                }
            $this->total = $total;
            return $this;
        // }
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function __toString()
    {
        
        return $this->name;
        
        
    }

    /**
     * @return Collection|Connection[]
     */
    public function getConnexion(): Collection
    {
        return $this->connexion;
    }

    public function addConnexion(Connection $connexion): self
    {
        if (!$this->connexion->contains($connexion)) {
            $this->connexion[] = $connexion;
        }

        return $this;
    }

    public function removeConnexion(Connection $connexion): self
    {
        if ($this->connexion->contains($connexion)) {
            $this->connexion->removeElement($connexion);
        }

        return $this;
    }

    
}
