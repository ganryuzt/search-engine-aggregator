<?php
namespace Ganryuzt\SearchEngineAggregator;

use GuzzleHttp\Client;

/**
 * Class Search
 * @package Ganryuzt\SearchEngineAggregator
 * @author Zurich Ferdian <zurich.ferdian@gmail.com>
 */
class Search implements SearchInterface
{

    /**
     * Aggregator
     *
     * @var \Ganryuzt\SearchEngineAggregator\Aggregator
     */
    protected $aggregator;

    /**
     * @var array
     */
    protected $engines = [];

    /**
     * Guzzle Client
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $config;

    /**
     * Search constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->aggregator = new Aggregator();
        $this->client = new Client();

        if (isset($config['engines'])) {
            $this->engines = $config['engines'];
        } else {
            $this->engines = ['google', 'yahoo'];
        }

    }

    /**
     * @param string $queryString
     * @return array
     */
    public function query($queryString ='')
    {
        foreach ($this->engines as $engine) {
            try {
                $className = ucfirst($engine);
                $className = 'Ganryuzt\SearchEngineAggregator\SearchEngine\\' . $className;
                /* @var $searchEngine \Ganryuzt\SearchEngineAggregator\SearchEngine\Google */


                $searchEngine = new $className();
                $searchResults = $searchEngine->setQueryString($queryString)->getSearchResults();
                $this->aggregator->addSearchResults($searchResults);
            } catch (\Exception $e) {
                continue;
            }
        }

        return $this->aggregator->getAggregatedResult();

    }

}