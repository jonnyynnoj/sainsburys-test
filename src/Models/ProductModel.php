<?php
namespace jonnyynnoj\Sainsburys\Models;

/**
 * Represents a product
 */
class ProductModel implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var float
     */
    protected $unitPrice;

    /**
     * @var string
     */
    protected $description;

    /**
     * Assign product properties
     * @param string $title
     * @param int    $size
     * @param float  $unitPrice
     * @param string $description
     */
    public function __construct($title, $size, $unitPrice, $description)
    {
        $this->title = $title;
        $this->size = $size;
        $this->unitPrice = $unitPrice;
        $this->description = $description;
    }

    /**
     * Title accessor
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Size accessor
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Unit price accessor
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Description accessor
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Define JSON representation
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
            'size' => round($this->size / 1024, 1) . 'kb',
            'unit_price' => $this->unitPrice,
            'description' => $this->description
        ];
    }
}
