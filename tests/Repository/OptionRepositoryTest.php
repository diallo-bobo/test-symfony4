<?php

namespace App\Tests\Repository;

use App\Repository\OptionRepository;
use App\Tests\FixturesTrait;
use App\Tests\RepositoryTestCase;

class OptionRepositoryTest extends RepositoryTestCase
{
    use FixturesTrait;

    /**
     * @var OptionRepository
     */
    protected $repository = null;

    protected $repositoryClass = OptionRepository::class;

    public function testCount()
    {
        $this->loadData();
        $this->assertEquals(3, $this->repository->count([]));
    }

    public function loadData(): void
    {
        $this->loadFixtures(['options']);
    }

    public function testFindAllOption(): void
    {
        $this->loadData();
        $this->assertCount(3, $this->repository->findAll());
    }
}
