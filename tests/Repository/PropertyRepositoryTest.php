<?php

namespace App\Tests\Repository;

use App\Entity\PropertySearch;
use App\Repository\PropertyRepository;
use App\Tests\FixturesTrait;
use App\Tests\RepositoryTestCase;
use Doctrine\ORM\Query;

class PropertyRepositoryTest extends RepositoryTestCase
{
    use FixturesTrait;

    /**
     * @var PropertyRepository
     */
    protected $repository = null;

    protected $repositoryClass = PropertyRepository::class;

    public function testCount()
    {
        $this->loadData();
        $this->assertEquals(9, $this->repository->count([]));
    }

    public function loadData(): void
    {
        $this->loadFixtures(['properties']);
    }

    public function testFindAllVisible(): void
    {
        $this->loadData();
        $this->assertCount(5, $this->repository->findAllVisible());
    }

    public function testFindLatedst(): void
    {
        $this->loadData();
        $this->assertCount(4, $this->repository->findLatest());
    }

    public function testAllFindAllVisibleQuery(): void
    {
        $search = new PropertySearch();
        $query = $this->repository->findAllVisibleQuery($search);

        $this->assertInstanceOf(Query::class, $query);
    }

    public function testAllFindAllVisibleQueryWithValues(): void
    {
        $search = (new PropertySearch())
            ->setMaxPrice(50000)
            ->setMinSurface(50);

        $query = $this->repository->findAllVisibleQuery($search);
        $this->assertInstanceOf(Query::class, $query);
    }
}
