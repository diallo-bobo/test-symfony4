<?php

namespace App\Tests\Entity;

use App\Entity\PropertySearch;
use App\Tests\KernelTestCase;
use App\Tests\ToolsTrait;

class PropertySearchTest extends KernelTestCase
{
    use ToolsTrait;

    /**
     * @var PropertySearch
     */
    private PropertySearch $propertySearh;

    protected function setUp(): void
    {
        parent::setUp();
        $this->propertySearh = (new PropertySearch())
            ->setMinSurface(10)
            ->setMaxPrice(50000);
    }

    public function testInvalidSearchWithSurfaceLessThan10()
    {
        $this->propertySearh->setMinSurface(5);
        $this->assertHasErrors($this->propertySearh, 1);
    }

    public function testInvalidSearchWithSurfaceGreaterThan400()
    {
        $this->propertySearh->setMinSurface(500);
        $this->assertHasErrors($this->propertySearh, 1);
    }
}
