<?php
namespace Ganryuzt\SearchEngineAggregator;

/**
 * Class Aggregator
 * @package Ganryuzt\SearchEngineAggregator
 * @author Zurich Ferdian <zurich.ferdian@gmail.com>
 */
class Aggregator
{

    protected $searchResults = [];

    /**
     * @return array
     */
    public function getAggregatedResult()
    {
        return $this->searchResults;
    }

    /**
     * @param array $searchResults
     * @return $this
     */
    public function addSearchResults($searchResults = [])
    {
        foreach ($searchResults as $url => $searchResult) {
            if (array_key_exists($url, $this->searchResults)) {
                $this->searchResults[$url]['source'] = array_merge(
                    $this->searchResults[$url]['source'],
                    $searchResult['source']
                );
            } else {
                $this->searchResults[$url] = $searchResult;
            }
        }
        return $this;
    }

}