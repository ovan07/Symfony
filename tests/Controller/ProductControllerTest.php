<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private function createProduct(string $name = 'Test Product'): Product
    {
        $product = new Product();
        $product->setName($name)
            ->setPrice('29.99')
            ->setStock(10);

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $em->persist($product);
        $em->flush();

        return $product;
    }

    public function testIndex(): void
    {
        $client = static::createClient();
        $this->createProduct();

        $client->request('GET', '/product');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Products');
    }

    public function testNewDisplaysForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/product/new');

        $this->assertResponseIsSuccessful();
    }

    public function testNewSubmitCreatesProduct(): void
    {
        $client = static::createClient();
        $client->request('GET', '/product/new');

        $client->submitForm('Create', [
            'product[name]' => 'New Laptop',
            'product[description]' => 'A powerful laptop',
            'product[price]' => '999.99',
            'product[stock]' => '5',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'New Laptop');
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $product = $this->createProduct('My Widget');

        $client->request('GET', '/product/' . $product->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'My Widget');
    }

    public function testEditDisplaysForm(): void
    {
        $client = static::createClient();
        $product = $this->createProduct();

        $client->request('GET', '/product/' . $product->getId() . '/edit');

        $this->assertResponseIsSuccessful();
    }

    public function testEditSubmitUpdatesProduct(): void
    {
        $client = static::createClient();
        $product = $this->createProduct('Old Product');

        $client->request('GET', '/product/' . $product->getId() . '/edit');

        $client->submitForm('Update', [
            'product[name]' => 'Updated Product',
            'product[price]' => '49.99',
            'product[stock]' => '20',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Updated Product');
    }

    public function testDelete(): void
    {
        $client = static::createClient();
        $product = $this->createProduct('To Delete');
        $id = $product->getId();

        $client->request('GET', '/product/' . $id);
        $client->submitForm('Delete');

        $this->assertResponseRedirects('/product');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $this->assertNull($em->find(Product::class, $id));
    }
}
