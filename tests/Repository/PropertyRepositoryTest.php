<?php

namespace App\Tests\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Repository\PropertyRepository;
use App\Tests\FixturesTrait;
use App\Tests\RepositoryTestCase;
use Doctrine\Common\Collections\ArrayCollection;
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
        $this->loadFixtures(['properties']);

        $search = (new PropertySearch())
            ->setMaxPrice(50000)
            ->setMinSurface(50);

        $query = $this->repository->findAllVisibleQuery($search);
        $this->assertInstanceOf(Query::class, $query);
        $properties = $query->getResult();

        $this->assertGreaterThan(0, count($properties));

        /** @var Property $property */
        foreach ($properties as $property) {
            $this->assertLessThanOrEqual(50000, $property->getPrice());
            $this->assertGreaterThanOrEqual(50, $property->getSurface());
        }
    }

    public function testAllFindAllVisibleQueryWithOptions(): void
    {
        /** @var Property $property */
        ['property4' => $property, 'option1' => $option] = $this->loadFixtures(['properties', 'options']);

        // Add option
        $em = self::$container->get('doctrine.orm.default_entity_manager');
        $property->addOption($option);
        $em->flush();

        // Search values
        $search = (new PropertySearch())
            ->setMaxPrice(50000)
            ->setMinSurface(50);
        $search->setOptions(new ArrayCollection([$option]));

        $query = $this->repository->findAllVisibleQuery($search);
        $this->assertInstanceOf(Query::class, $query);
        $properties = $query->getResult();

        $this->assertGreaterThan(0, count($properties));

        /** @var Property $property */
        foreach ($properties as $property) {
            $this->assertLessThanOrEqual(50000, $property->getPrice());
            $this->assertGreaterThanOrEqual(50, $property->getSurface());
            $this->assertGreaterThan(0, $property->getOptions()->count());
            $this->assertGreaterThanOrEqual($option->getName(), $property->getOptions()[0]);
        }
    }
}
