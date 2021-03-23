<?php

namespace App\Tests\Controller;

use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Bundle\SecurityBundle\DataCollector\SecurityDataCollector;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
   use FixturesTrait;

   public function testLogin()
   {
      $this->client->request('GET', '/login');
      $this->assertResponseStatusCodeSame(Response::HTTP_OK);
      $this->assertSelectorTextContains('label', "Non d'utilisateur");
   }

   public function testLoginBadCredential()
   {
      $crawler = $this->client->request('GET', '/login');
      $form = $crawler->selectButton('Se connecter')->form([
         '_username' => 'demo',
         '_password' => 'demo'
      ]);
      $this->client->submit($form);
      $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
      $this->client->followRedirect();
      $this->assertSelectorTextContains('.alert.alert-danger', 'Identifiants invalides');
   }

   public function testLoginWithValidCredential()
   {
      $this->loadFixtures(['users']);

      $crawler = $this->client->request('GET', '/login');
      $this->client->enableProfiler();

      $form = $crawler->selectButton('Se connecter')->form([
         '_username' => 'bobo',
         '_password' => 'bdiallo'
      ]);
      $this->client->submit($form);
      $this->assertTrue($this->isAuthenticated());
   }

   /*public function testLogout()
   {
      $this->client->request('GET', '/logout');
      $this->assertResponseRedirects(Response::HTTP_FOUND);
   }*/

   /**
    * @return bool
    */
   public function isAuthenticated(): bool
   {
      /** @var SecurityDataCollector $securityCollector * */
      $securityCollector = $this->client->getProfile()->getCollector('security');

      return $securityCollector->isAuthenticated();
   }

}
