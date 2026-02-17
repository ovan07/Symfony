<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $category = new Category();

        $this->assertNull($category->getId());
        $this->assertNull($category->getName());

        $category->setName('Electronics');
        $this->assertSame('Electronics', $category->getName());
    }

    public function testAddProduct(): void
    {
        $category = new Category();
        $product = new Product();

        $result = $category->addProduct($product);

        $this->assertSame($category, $result);
        $this->assertCount(1, $category->getProducts());
        $this->assertSame($category, $product->getCategory());
    }

    public function testAddProductDoesNotDuplicate(): void
    {
        $category = new Category();
        $product = new Product();

        $category->addProduct($product);
        $category->addProduct($product);

        $this->assertCount(1, $category->getProducts());
    }

    public function testRemoveProduct(): void
    {
        $category = new Category();
        $product = new Product();

        $category->addProduct($product);
        $result = $category->removeProduct($product);

        $this->assertSame($category, $result);
        $this->assertCount(0, $category->getProducts());
        $this->assertNull($product->getCategory());
    }

    public function testToString(): void
    {
        $category = new Category();
        $this->assertSame('', (string) $category);

        $category->setName('Books');
        $this->assertSame('Books', (string) $category);
    }

    public function testFluentInterface(): void
    {
        $category = new Category();
        $result = $category->setName('Test');
        $this->assertSame($category, $result);
    }
}
