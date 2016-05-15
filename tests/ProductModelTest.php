<?php

use jonnyynnoj\Sainsburys\Models\ProductModel;

class ProductModelTest extends PHPUnit_Framework_TestCase
{
    protected $expected = [
        'title' => 'product1',
        'size' => '12.1kb',
        'unit_price' => 1.39,
        'description' => 'product 1 description'
    ];

    public function testInit()
    {
        $product = $this->getModel();

        $this->assertEquals($product->getTitle(), $this->expected['title']);
        $this->assertEquals($product->getSize(), 12345);
        $this->assertEquals($product->getUnitPrice(), $this->expected['unit_price']);
        $this->assertEquals($product->getDescription(), $this->expected['description']);
    }

    public function testSerialize()
    {
        $product = $this->getModel();
        $this->assertEquals(json_encode($product), json_encode($this->expected));
    }

    protected function getModel()
    {
        return new ProductModel(
            $this->expected['title'],
            12345,
            $this->expected['unit_price'],
            $this->expected['description']
        );
    }
}
