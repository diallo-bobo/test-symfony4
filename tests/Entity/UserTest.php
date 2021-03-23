<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;
use App\Tests\ToolsTrait;

class UserTest extends KernelTestCase
{
   use FixturesTrait;
   use ToolsTrait;

   /**
    * @var User
    */
   protected User $user;

   public function testTrue()
   {
      $this->assertTrue(true);
   }

   protected function setUp(): void
   {
      parent::setUp();
      $this->user = (new User())
         ->setUsername('demo')
         ->setPassword('demo');
   }
}
