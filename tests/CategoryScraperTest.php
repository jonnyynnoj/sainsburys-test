<?php

use jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException;
use jonnyynnoj\Sainsburys\Factories\ProductScraperFactory;
use jonnyynnoj\Sainsburys\Scrapers\CategoryScraper;
use jonnyynnoj\Sainsburys\Scrapers\ProductScraper;

class CategoryScraperTest extends ResponseTest
{
    public static function setUpBeforeClass()
    {
        self::mockClient([
            self::makeResponse('categoryScraper', 'expected'),
            self::makeResponse('categoryScraper', 'unexpected'),
        ]);
    }

    public function testExpectedResponse()
    {
        $productServiceFactory = new ProductScraperFactory(self::$goutte);

        $categoryScraper = new CategoryScraper(self::$goutte, $productServiceFactory);
        $products = $categoryScraper->fetch();

        $this->assertCount(7, $products);
        $this->assertContainsOnlyInstancesOf(ProductScraper::class, $products);
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
