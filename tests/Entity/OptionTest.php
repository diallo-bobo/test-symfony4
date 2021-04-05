<?php

namespace App\Tests\Entity;

use App\Entity\Option;
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
}
