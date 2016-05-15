<?php
namespace jonnyynnoj\Sainsburys;

use Illuminate\Container\Container;
use Goutte\Client;

class ServiceProvider
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function register()
    {
        $this->container->alias('jonnyynnoj\Sainsburys\Commands\FetchProductsCommand', 'FetchProductsCommand');
        $this->container->singleton('Goutte\Client');

        $this->container->extend('jonnyynnoj\Sainsburys\Scrapers\CategoryScraper', function($categoryScraper) {
            $categoryScraper->setUrl('http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html');
            return $categoryScraper;
        });
    }
}
