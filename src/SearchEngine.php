<?php
namespace Ganryuzt\SearchEngineAggregator;

use GuzzleHttp\Client;

/**
 * Class SearchEngine
 * @package Ganryuzt\SearchEngineAggregator
 * @author Zurich Ferdian <zurich.ferdian@gmail.com>
 */
abstract class SearchEngine
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $queryString;

    /**
     * SearchEngine constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return mixed
     */
    abstract function getSearchResults();

    /**
     * Set query string
     *
     * @param string $query
     * @return $this
     */
    public function setQueryString($query)
    {
        $this->queryString = $query;

        return $this;
    }

    /**
     * Get html doc of url
     *
     * @param string $url
     * @return \DOMDocument
     */
    protected function getHtmlDoc($url)
    {
        $response = $this->client->request('GET', $url)
            ->getBody()
            ->getContents();
        $htmlDoc = new \DOMDocument();
        $htmlDoc->loadHTML($response);

        return $htmlDoc;
    }


}