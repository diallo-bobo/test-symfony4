<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    /**
     * Log a user
     * @param User|null $user
     */
    public function login(?User $user): void
    {
        if (null === $user) {
            return;
        }

        $session = $this->client->getContainer()->get('session');
        // 'main' est le nom du firewalls dans le fichier 'security.yaml'
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * @param string $title
     */
    public function expectH1(string $title): void
    {
        $crawler = $this->client->getCrawler();
        $this->assertEquals(
            $title,
            $crawler->filter('h1')->text(),
            '<h1> missmatch'
        );
    }

    /**
     * @param string $title
     */
    public function expectTitle(string $title): void
    {
        $crawler = $this->client->getCrawler();
        $this->assertEquals(
            $title,
            $crawler->filter('title')->text(),
            '<title> missmatch',
        );
    }

    /**
     * @param string $type
     */
    public function expectAlert(string $type): void
    {
        $this->assertEquals(1, $this->client->getCrawler()->filter('.alert.alert-' . $type)->count());
    }

    public function expectSuccessAlert(): void
    {
        $this->expectAlert('success');
    }

    /**
     * @param string $type
     * @param string $message
     */
    public function expectAlertWithMessage(string $type, string $message): void
    {
        $this->assertSelectorTextContains('.alert.alert-' . $type, $message);
    }

    /**
     * @param int|null $expectedErrors
     */
    public function expectFormErrors(?int $expectedErrors = null): void
    {
        if (null === $expectedErrors) {
            $this->assertTrue($this->client->getCrawler()->filter('.form-error-message')->count() > 0, 'Form errors missmatch.');
        } else {
            $this->assertEquals($expectedErrors, $this->client->getCrawler()->filter('.form-error-message')->count(), 'Form errors missmatch.');
        }
    }
}
