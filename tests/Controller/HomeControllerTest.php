<?php

namespace App\Tests\Controller;

use App\Entity\Property;
use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testIndex()
    {
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h2', 'Les derniers biens');
    }

    public function testShowDetailsProduct()
    {
        /** @var Property $property * */
        ['property1' => $property] = $this->loadFixtures(['properties']);

        $crawler = $this->client->request('GET', '/');
        $link = $crawler->selectLink($property->getTitle())->link();
        $this->client->click($link);
        $this->assertSelectorTextContains('h1', $property->getTitle());
    }
}
