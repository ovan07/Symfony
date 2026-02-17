<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/category');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Categories');
    }
}
