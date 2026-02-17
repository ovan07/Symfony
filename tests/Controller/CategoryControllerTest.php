<?php

namespace App\Tests\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    private function createCategory(string $name = 'Test Category'): Category
    {
        $category = new Category();
        $category->setName($name);

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $em->persist($category);
        $em->flush();

        return $category;
    }

    public function testIndex(): void
    {
        $client = static::createClient();
        $this->createCategory();

        $client->request('GET', '/category');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Categories');
    }

    public function testNewDisplaysForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/category/new');

        $this->assertResponseIsSuccessful();
    }

    public function testNewSubmitCreatesCategory(): void
    {
        $client = static::createClient();
        $client->request('GET', '/category/new');

        $client->submitForm('Create', [
            'category[name]' => 'Electronics',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Electronics');
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $category = $this->createCategory('Books');

        $client->request('GET', '/category/' . $category->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Books');
    }

    public function testEditDisplaysForm(): void
    {
        $client = static::createClient();
        $category = $this->createCategory();

        $client->request('GET', '/category/' . $category->getId() . '/edit');

        $this->assertResponseIsSuccessful();
    }

    public function testEditSubmitUpdatesCategory(): void
    {
        $client = static::createClient();
        $category = $this->createCategory('Old Name');

        $client->request('GET', '/category/' . $category->getId() . '/edit');

        $client->submitForm('Update', [
            'category[name]' => 'New Name',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'New Name');
    }

    public function testDelete(): void
    {
        $client = static::createClient();
        $category = $this->createCategory('To Delete');
        $id = $category->getId();

        $client->request('GET', '/category/' . $id);
        $client->submitForm('Delete');

        $this->assertResponseRedirects('/category');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $this->assertNull($em->find(Category::class, $id));
    }
}
