<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\FixturesTrait;
use App\Tests\RepositoryTestCase;
use App\Tests\ToolsTrait;

class UserRepositoryTest extends RepositoryTestCase
{
    use FixturesTrait;
    use ToolsTrait;

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

    public function testUserRetrieveDatabaseIsValid(): void
    {
        $this->loadData();
        $user = $this->repository->findAll()[0];
        $this->assertNotNull($user->getId());
        $this->assertHasErrors($user, 0);
    }
}
