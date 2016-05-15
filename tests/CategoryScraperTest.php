<?php

use GuzzleHttp\Psr7\Response;
use jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException;
use jonnyynnoj\Sainsburys\Factories\ProductScraperFactory;
use jonnyynnoj\Sainsburys\Scrapers\CategoryScraper;
use jonnyynnoj\Sainsburys\Scrapers\ProductScraper;

class CategoryScraperTest extends ResponseTest
{
    public static function setUpBeforeClass()
    {
        self::mockClient([
            new Response(200, [], self::makeResponse('categoryScraper', 'expected')),
            new Response(200, [], self::makeResponse('categoryScraper', 'unexpected')),
        ]);
    }

    public function testExpectedResponse()
    {
        $productServiceFactory = new ProductScraperFactory(self::$goutte);

        $categoryScraper = new CategoryScraper(self::$goutte, $productServiceFactory);
        $products = $categoryScraper->fetch();

        $this->assertEquals(count($products), 7);

        foreach ($products as $product) {
            $this->assertInstanceOf(ProductScraper::class, $product);
        }
    }

    /**
     * @expectedException  jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException
     */
    public function testUnexpectedResponse()
    {
        $productServiceFactory = new ProductScraperFactory(self::$goutte);

        $categoryScraper = new CategoryScraper(self::$goutte, $productServiceFactory);
        $products = $categoryScraper->fetch();
    }
}
