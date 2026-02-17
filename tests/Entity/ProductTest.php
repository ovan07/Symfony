<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $product = new Product();

        $this->assertNull($product->getId());
        $this->assertNull($product->getName());
        $this->assertNull($product->getDescription());
        $this->assertNull($product->getPrice());
        $this->assertNull($product->getStock());
        $this->assertNull($product->getCategory());

        $product->setName('Test Product');
        $this->assertSame('Test Product', $product->getName());

        $product->setDescription('A description');
        $this->assertSame('A description', $product->getDescription());

        $product->setPrice('19.99');
        $this->assertSame('19.99', $product->getPrice());

        $product->setStock(50);
        $this->assertSame(50, $product->getStock());
    }

    public function testSetCategory(): void
    {
        $product = new Product();
        $category = new Category();
        $category->setName('Electronics');

        $product->setCategory($category);
        $this->assertSame($category, $product->getCategory());
    }

    public function testSetCategoryNull(): void
    {
        $product = new Product();
        $category = new Category();

        $product->setCategory($category);
        $product->setCategory(null);
        $this->assertNull($product->getCategory());
    }

    public function testFluentInterface(): void
    {
        $product = new Product();

        $result = $product
            ->setName('Test')
            ->setDescription('Desc')
            ->setPrice('9.99')
            ->setStock(10)
            ->setCategory(null);

        $this->assertSame($product, $result);
    }
}
