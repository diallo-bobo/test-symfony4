<?php

namespace App\Tests\Entity;

use App\Entity\Property;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;
use App\Tests\ToolsTrait;

class PropertyTest extends KernelTestCase
{
   use FixturesTrait;
   use ToolsTrait;

   public function testValidProperty()
   {
      $this->loadFixtures(['properties']);
      $this->assertHasErrors($this->getProperty(), 0);
   }

   /**
    * @return Property
    */
   public function getProperty(): Property
   {
      return (new Property())
         ->setTitle('Agence 1')
         ->setSurface(80)
         ->setRooms(4)
         ->setBedrooms(3)
         ->setFloor(1)
         ->setHeat(2)
         ->setAddress('Dakar, Scat Urbam')
         ->setCity('Dakar')
         ->setPostalCode('11500')
         ->setPrice(1500);
   }

   public function testValidPropertyWithNullTitle()
   {
      $this->loadFixtures(['properties']);
      $property = $this->getProperty()->setTitle('');
      $this->assertHasErrors($property, 1);
   }

   public function testCreatedAtIsNotNullOnNewInstance()
   {
      $this->assertNotNull($this->getProperty()->getCreatedAt());
   }

   public function testSoldIsNotNullOnNewInstance()
   {
      $this->assertNotNull($this->getProperty()->getSold());
   }

   public function testSlugTitle()
   {
      $property = $this->getProperty()->setTitle('Oh My God');
      $this->assertEquals('oh-my-god', $property->getSlug());
   }

}
