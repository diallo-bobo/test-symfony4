<?php

namespace App\Tests;

/**
 * @template E
 * Class RepositoryTestCase
 * @package App\Tests
 */
class RepositoryTestCase extends KernelTestCase
{
   /**
    * @var E
    */
   protected $repository = null;

   /**
    * @var class-string<E>
    */
   protected $repositoryClass = null;

   public function setUp(): void
   {
      parent::setUp();
      $this->repository = self::$container->get($this->repositoryClass);
   }
}
