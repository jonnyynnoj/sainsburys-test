<?php

use jonnyynnoj\Sainsburys\Collections\ProductsCollection;
use jonnyynnoj\Sainsburys\Models\ProductModel;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    protected $prices = [1.39, 2];

    public function testInit()
    {
        $models = $this->getProductMocks();

        $collection = new ProductsCollection($models);
        $products = $collection->getProducts();

        $this->assertEquals(count($products), count($models));
        $this->assertEquals($products[0], $models[0]);
        $this->assertEquals($products[1], $models[1]);
    }

    public function testTotalPrice()
    {
        $collection = new ProductsCollection($this->getProductMocks());
        $this->assertEquals($collection->getTotal(), array_sum($this->prices));
    }

    public function testSerialize()
    {
        $expected = [
            'results' => [[
                'title' => 'product1',
                'size' => '32kb',
                'unit_price' => $this->prices[0],
                'description' => 'product 1 description'
            ], [
                'title' => 'product2',
                'size' => '41kb',
                'unit_price' => $this->prices[1],
                'description' => 'product 2 description'
            ]],
            'total' => array_sum($this->prices)
        ];

        $models = $this->getProductMocks();

        foreach ($expected['results'] as $k => $data) {
            $models[$k]->shouldReceive('jsonSerialize')->andReturn($data);
        }

        $collection = new ProductsCollection($models);

        $this->assertEquals(json_encode($collection), json_encode($expected));
    }

    protected function getProductMocks()
    {
        $product1 = Mockery::mock(ProductModel::class);
        $product1->shouldReceive('getUnitPrice')->once()->andReturn($this->prices[0]);

        $product2 = Mockery::mock(ProductModel::class);
        $product2->shouldReceive('getUnitPrice')->once()->andReturn($this->prices[1]);

        return [$product1, $product2];
    }
}
