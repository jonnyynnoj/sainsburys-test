<?php
namespace jonnyynnoj\Sainsburys\Scrapers;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException;
use jonnyynnoj\Sainsburys\Models\ProductModel;

/**
 * Scraper class to scrape data from individual product page
 */
class ProductScraper extends BaseScraper
{
    /**
     * Send request to product page and scrape data
     * @return ProductModel
     */
    public function fetch()
    {
        $this->crawler = $this->sendRequest();

        try {
            return new ProductModel(
                $this->getTitle(),
                $this->getSize(),
                $this->getUnitPrice(),
                $this->getDescription()
            );
        }
        catch (\InvalidArgumentException $e) {
            throw new UnexpectedResponseException('Invalid product response in ' . __METHOD__);
        }
    }

    /**
     * Get product title from DOM
     * @return string
     */
    public function getTitle()
    {
        return $this->crawler->filter('h1')->first()->text();
    }

    /**
     * Get size in bytes of http response
     * @return int
     */
    public function getSize()
    {
        return (int) $this->client->getResponse()->getHeader('Content-Length');
    }

    /**
     * Get product price from DOM
     * @return float
     */
    public function getUnitPrice()
    {
        $price = $this->crawler->filter('.pricePerUnit')->text();
        return (float) preg_replace('/[^\d\.]/', '', $price);
    }

    /**
     * Get product description from DOM
     * @return string
     */
    public function getDescription()
    {
        return $this->crawler->filter('.productText p')->first()->text();
    }
}
