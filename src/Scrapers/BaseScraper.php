<?php
namespace jonnyynnoj\Sainsburys\Scrapers;

use Goutte\Client;

/**
 * Base Scraper abstract class
 */
abstract class BaseScraper
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $url;

    /**
     * Inject client dependency
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set url for next request
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Shortcut method to send GET request to current url
     * @return \Symfony\Component\DomScraper\Scraper
     */
    public function sendRequest()
    {
        return $this->client->request('GET', $this->url);
    }

    /**
     * Method that will be called from command. Sub-classes should implement
     * @return mixed
     */
    abstract public function fetch();
}
