<?php

namespace App\Tests\Entity;

use App\Entity\Option;
use App\Entity\Property;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;
use App\Tests\ToolsTrait;

class OptionTest extends KernelTestCase
{
    use FixturesTrait;
    use ToolsTrait;

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getOption(), 0);
    }

    public function getOption(): Option
    {
        return (new Option())
            ->setName('One option');
    }


    public function testAddPropertyAtOption()
    {
        $option = $this->getOption();
        $this->assertEquals(0, $option->getProperties()->count());

        $option->addProperty((new Property())->setTitle('Un bien'));
        $this->assertEquals(1, $option->getProperties()->count());
    }

    public function testRemoveOptionAtProperty()
    {
        $option = $this->getOption();

        $property = (new Property())->setTitle('Un bien');
        $option->addProperty($property);
        $this->assertEquals(1, $option->getProperties()->count());

        $option->removeProperty($property);
        $this->assertEquals(0, $option->getProperties()->count());
    }
}
