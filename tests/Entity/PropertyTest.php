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
      // NotBlak and min lenght
      $property = $this->getProperty()->setTitle('');
      $this->assertHasErrors($property, 2);
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

   public function testValidationSurface()
   {
      $this->assertHasErrors($this->getProperty()->setSurface(20), 0);
      $this->assertHasErrors($this->getProperty()->setSurface(5), 1);
      $this->assertHasErrors($this->getProperty()->setSurface(500), 1);
   }

   public function testValidationPostalCode()
   {
      $this->assertHasErrors($this->getProperty()->setPostalCode(55555), 0);
      $this->assertHasErrors($this->getProperty()->setPostalCode(333), 1);
      $this->assertHasErrors($this->getProperty()->setPostalCode(4444), 1);
      $this->assertHasErrors($this->getProperty()->setPostalCode(666666), 1);
   }

   public function testValidationTitle()
   {
      $this->assertHasErrors($this->getProperty()->setTitle('aaaaa'), 0);
      $this->assertHasErrors($this->getProperty()->setTitle('aaaa'), 1);
   }

   public function testUniqueProperty()
   {
      ['property1' => $property] = $this->loadFixtures(['properties']);
      $this->assertHasErrors($this->getProperty()->setTitle($property->getTitle()), 1);
   }

}
