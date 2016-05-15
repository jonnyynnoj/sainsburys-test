<?php

use GuzzleHttp\Psr7\Response;
use jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException;
use jonnyynnoj\Sainsburys\Models\ProductModel;
use jonnyynnoj\Sainsburys\Scrapers\ProductScraper;

class ProductScraperTest extends ResponseTest
{
    public static function setUpBeforeClass()
    {
        self::mockClient([
            new Response(200, [], self::makeResponse('productScraper', 'expected')),
            new Response(200, [], self::makeResponse('productScraper', 'unexpected')),
        ]);
    }

    public function testExpectedResponse()
    {
        $productScraper = new ProductScraper(self::$goutte);
        $product = $productScraper->fetch();

        $this->assertInstanceOf(ProductModel::class, $product);
        $this->assertEquals($product->getTitle(), 'Sainsbury\'s Apricot Ripe & Ready x5');
        $this->assertEquals($product->getUnitPrice(), 3.5);
        $this->assertEquals($product->getDescription(), 'Apricots');
    }

    /**
     * @expectedException  jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException
     */
    public function testUnexpectedResponse()
    {
        $productScraper = new ProductScraper(self::$goutte);
        $product = $productScraper->fetch();
    }
}
