<?php

namespace App\Tests\Controller\Admin;

use App\Entity\Option;
use App\Repository\OptionRepository;
use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminOptionControllerTest extends WebTestCase
{
    use FixturesTrait;

    /**
     * @var OptionRepository
     */
    protected OptionRepository $optionRepository;

    public function testIndexAdminOptions(): void
    {
        $this->loadData();
        $this->logAdmin();
        $this->client->request('GET', '/admin/options/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectTitle('Gérer des options');
    }

    /**
     * @return object[]
     */
    private function loadData(): array
    {
        return $this->loadFixtures(['options']);
    }

    public function logAdmin()
    {
        $users = $this->loadFixtures(['users']);
        $this->login($users['user-admin']);
    }

    public function testShowFormEditOption(): void
    {
        /** @var Option $option * */
        ['option1' => $option] = $this->loadData();

        $this->logAdmin();
        $this->client->request('GET', '/admin/options/' . $option->getId() . '/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectH1('Editer l\'option');
    }

    public function testShowFormCreateOption(): void
    {
        $this->logAdmin();
        $this->client->request('GET', '/admin/options/new');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectH1('Ajouter une nouvelle option');
    }

    public function testCreateNewOption(): void
    {
        $this->logAdmin();
        $count = $this->optionRepository->count([]);

        $crawler = $this->client->request('GET', '/admin/options/new');
        $form = $crawler->selectButton('Ajouter')->form([
            'option[name]' => 'New option',
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects('/admin/options/');
        $this->assertEquals($count + 1, $this->optionRepository->count([]));
    }

    public function testEditOption(): void
    {
        $this->logAdmin();

        /** @var Option $option */
        ['option1' => $option] = $this->loadData();

        $crawler = $this->client->request('GET', '/admin/options/' . $option->getId() . '/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectH1('Editer l\'option');

        $form = $crawler->selectButton('Editer')->form([
            'option[name]' => 'Option edited'
        ]);

        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.alert.alert-success', 'Bien modifié avec success');
    }

    public function testDeleteOption(): void
    {
        $this->logAdmin();
        ['count' => $count] = $this->loadDataAndCountRows();

        $crawler = $this->client->request('GET', '/admin/options/');
        $form = $crawler
            ->selectButton('Supprimer')
            ->eq(0)
            ->form();

        $this->client->submit($form);
        $rows = $this->optionRepository->count([]);
        $this->assertEquals($count - 1, $rows);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('.alert.alert-success', 'Bien supprimé avec success');
    }

    /**
     * @return array<mixed>
     */
    public function loadDataAndCountRows(): array
    {
        return [
            'option' => $this->loadData()['option1'],
            'count' => $this->optionRepository->count([])
        ];
    }

    public function testNotDeleteOptionWithInvalidToken(): void
    {
        $this->logAdmin();
        ['count' => $count] = $this->loadDataAndCountRows();

        $crawler = $this->client->request('GET', '/admin/options/');
        $form = $crawler
            ->selectButton('Supprimer')
            ->eq(0)
            ->form([
                '_method' => 'DELETE',
                '_token' => 'invalidToken',
            ]);
        $this->client->submit($form);

        $this->assertEquals($count, $this->optionRepository->count([]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Gérer les options');
    }

    public function testDeleteOptionWithValidToken(): void
    {
        $this->logAdmin();
        ['option' => $option, 'count' => $count] = $this->loadDataAndCountRows();

        $crawler = $this->client->request('GET', '/admin/options/');
        $csrfToken = $this->client->getContainer()
            ->get('security.csrf.token_manager')
            ->getToken('delete' . $option->getId());

        $form = $crawler
            ->selectButton('Supprimer')
            ->eq(0)
            ->form([
                '_method' => 'DELETE',
                '_token' => $csrfToken,
            ]);
        $this->client->submit($form);
        $this->assertEquals($count - 1, $this->optionRepository->count([]));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->optionRepository = self::$container->get(OptionRepository::class);
    }
}
