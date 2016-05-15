<?php
namespace jonnyynnoj\Sainsburys\Collections;

/**
 * Simple collection class to hold list of products
 */
class ProductsCollection implements \JsonSerializable
{
    /**
     * Array of products
     * @var Models\ProductModel[]
     */
    protected $products = [];

    /**
     * Constructor, assign products
     * @param Models\ProductModel[] $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Products accessor
     * @return Models\ProductModel[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Return the sum unit price of products in collection
     * @return float
     */
    public function getTotal()
    {
        return array_reduce($this->products, function($total, $product) {
            return $total + $product->getUnitPrice();
        });
    }

    /**
     * Define JSON representation
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'results' => $this->products,
            'total' => $this->getTotal()
        ];
    }
}
