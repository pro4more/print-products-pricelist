<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
     * @ORM\OneToMany(targetEntity=PricelistEntry::class, mappedBy="product", orphanRemoval=true)
     * @ORM\OrderBy({"format" = "ASC", "material" = "ASC", "pages" = "ASC", "copies" = "ASC"})
     */
    private $pricelistEntries;

    public function __construct()
    {
        $this->pricelistEntries = new ArrayCollection();
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

    /**
     * @return Collection|PricelistEntry[]
     */
    public function getPricelistEntries(): Collection
    {
        return $this->pricelistEntries;
    }

    public function getPricelistEntriesMultiDim(): array
    {
        $multiDim = [];
        $previousGroup = '';
        $currentInd = -1;
        foreach ($this->getPricelistEntries() as $entry) {
            $currentGroup = $entry->getMaterial()->getName().$entry->getFormat()->getName().$entry->getPages();
            if ($currentGroup != $previousGroup) {
                $multiDim[++$currentInd] = [
                    'data' => [],
                    'material' => $entry->getMaterial()->getName(),
                    'format' => $entry->getFormat()->getName(),
                    'pages' => $entry->getPages(),
                ];
            }
            $multiDim[$currentInd]['data'][] = $entry;
            $previousGroup = $currentGroup;
        }
        return $multiDim;
    }

    public function addPricelistEntry(PricelistEntry $pricelistEntry): self
    {
        if (!$this->pricelistEntries->contains($pricelistEntry)) {
            $this->pricelistEntries[] = $pricelistEntry;
            $pricelistEntry->setProduct($this);
        }

        return $this;
    }

    public function removePricelistEntry(PricelistEntry $pricelistEntry): self
    {
        if ($this->pricelistEntries->contains($pricelistEntry)) {
            $this->pricelistEntries->removeElement($pricelistEntry);
            // set the owning side to null (unless already changed)
            if ($pricelistEntry->getProduct() === $this) {
                $pricelistEntry->setProduct(null);
            }
        }

        return $this;
    }
}
