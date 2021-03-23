<?php

namespace App\Tests\Repository;

use App\Repository\UserRepository;
use App\Tests\FixturesTrait;
use App\Tests\RepositoryTestCase;

class UserRepositoryTest extends RepositoryTestCase
{
   use FixturesTrait;

   /**
    * @var UserRepository
    */
   protected $repository = null;

   protected $repositoryClass = UserRepository::class;

   public function testCount()
   {
      $this->loadData();
      $this->assertEquals(10, $this->repository->count([]));
   }

   public function loadData(): void
   {
      $this->loadFixtures(['users']);
   }
}
