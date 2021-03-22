<?php

namespace App\Tests\Controller;

use App\Entity\Property;
use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PropertyControllerTest extends WebTestCase
{
   use FixturesTrait;

   public function testIndex(): void
   {
      $this->client->request('GET', '/biens');
      $this->assertResponseStatusCodeSame(Response::HTTP_OK);
      $this->assertSelectorTextContains('h1', 'Voir tous vos biens');
   }

   public function testShow(): void
   {
      /** @var Property $property */
      ['property1' => $property] = $this->loadData();

      $this->client->request('GET', '/biens/' . $property->getSlug() . '-' . $property->getId());
      $this->assertResponseStatusCodeSame(Response::HTTP_OK);
      $this->assertSelectorTextContains('h1', $property->getTitle());
   }

   /**
    * @return array<object>
    */
   public function loadData(): array
   {
      return $this->loadFixtures(['properties']);
   }

   public function testRedirectShowIfSlugIsNotCorrect(): void
   {
      /** @var Property $property */
      ['property1' => $property] = $this->loadData();

      $this->client->request('GET', '/biens/bobo-' . $property->getId());
      $this->assertResponseStatusCodeSame(Response::HTTP_MOVED_PERMANENTLY);
   }

}
