<?php
namespace jonnyynnoj\Sainsburys\Scrapers;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException;
use jonnyynnoj\Sainsburys\Factories\ProductScraperFactory;

/**
 * Scraper service to crawl prouduct category page
 */
class CategoryScraper extends BaseScraper
{
    /**
     * Inject dependencies
     * @param Client                $client
     * @param ProductScraperFactory $productScraperFactory
     */
    public function __construct(Client $client, ProductScraperFactory $productScraperFactory)
    {
        parent::__construct($client);
        $this->productScraperFactory = $productScraperFactory;
    }

    /**
     * Scrape category and return an array of product scrapers
     * @return jonnyynnoj\Sainsburys\Scrapers\ProductScraper[]
     */
    public function fetch()
    {
        $crawler = $this->sendRequest();
        $productsFilter = $crawler->filter('.productInner');

        if (!$productsFilter->count()) {
            throw new UnexpectedResponseException('Invalid category response in ' . __METHOD__);
        }

        // loop through each found product and return ProductScraper instance
        return $productsFilter->each(function(Crawler $node) {
            $productScraper = $this->productScraperFactory->make();
            $productScraper->setUrl($this->getProductUrl($node));
            return $productScraper;
        });
    }

    /**
     * Given a product node, get the url of the product page
     * @param  Crawler $node
     * @return string
     */
    public function getProductUrl(Crawler $node)
    {
        return $node->filter('h3 a')->first()->attr('href');
    }
}
