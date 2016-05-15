<?php
namespace jonnyynnoj\Sainsburys\Factories;

use Goutte\Client;
use jonnyynnoj\Sainsburys\Scrapers\ProductScraper;

/**
 * Factory to create ProductScraper instances
 */
class ProductScraperFactory
{
    /**
     * Inject client dependency
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Make a new Scraper instances
     * @return ProductScraper
     */
    public function make()
    {
        return new ProductScraper($this->client);
    }
}
