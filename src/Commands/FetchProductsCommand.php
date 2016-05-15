<?php
namespace jonnyynnoj\Sainsburys\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use jonnyynnoj\Sainsburys\Exceptions\UnexpectedResponseException;
use jonnyynnoj\Sainsburys\Scrapers\CategoryScraper;
use jonnyynnoj\Sainsburys\Scrapers\ProductScraper;
use jonnyynnoj\Sainsburys\Collections\ProductsCollection;

/**
 * Products fetcher command
 */
class FetchProductsCommand extends Command
{
    /**
     * Inject dependency
     * @param CategoryScraper $categoryScraper
     */
    public function __construct(CategoryScraper $categoryScraper)
    {
        parent::__construct();
        $this->categoryScraper = $categoryScraper;
    }

    /**
     * Configure command
     * @return void
     */
    public function configure()
    {
        $this->setName('products:scrape')
            ->setDescription('Return sainsburys products as JSON')
            ->addOption('url', null, InputOption::VALUE_REQUIRED);
    }

    /**
     * Execute command and return json output
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getOption('url');

        // if url has been manually passed, set it
        if ($url) {
            $this->categoryScraper->setUrl($url);
        }

        try {
            $productScrapers = $this->categoryScraper->fetch();

            $products = array_map(function(ProductScraper $product) {
                return $product->fetch();
            }, $productScrapers);

            $results = new ProductsCollection($products);
            $output->writeln(json_encode($results));
        }
        catch (UnexpectedResponseException $e) {
            $output->writeln('Unexpected response: ' . $e->getMessage());
        }
        catch (\Exception $e) {
            $output->writeln('Error occurred: ' . $e->getMesssage());
        }
    }
}
