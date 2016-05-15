<?php

use Goutte\Client;
use jonnyynnoj\Sainsburys\Factories\ProductScraperFactory;
use jonnyynnoj\Sainsburys\Scrapers\ProductScraper;

class ProductScraperFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testItWorks()
    {
        $client = new Client;
        $productServiceFactory = new ProductScraperFactory($client);

        $this->assertInstanceOf(ProductScraper::class, $productServiceFactory->make());
    }
}
