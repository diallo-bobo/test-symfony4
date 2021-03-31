<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PropertySearch
 * @package App\Entity
 */
class PropertySearch
{
    /**
     * @var int|null
     */
    private ?int $maxPrice = null;

    /**
     * @var int|null
     * @Assert\Range(min="10", max="400")
     */
    private ?int $minSurface = null;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    public function setMinSurface(?int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }
}
