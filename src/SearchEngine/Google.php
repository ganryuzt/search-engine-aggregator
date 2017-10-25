<?php
namespace Ganryuzt\SearchEngineAggregator\SearchEngine;

use Ganryuzt\SearchEngineAggregator\SearchEngine;

/**
 * Class Google
 * @package Ganryuzt\SearchEngineAggregator\SearchEngine
 * @author Zurich Ferdian <zurich.ferdian@gmail.com>
 */
class Google extends SearchEngine
{

    const SOURCE = 'google';

    const SEARCH_URL = 'https://www.google.nl/search?';

    /**
     * Get Search Results
     *
     * @return array
     * @throws \Exception
     */
    public function getSearchResults()
    {
        $queryParams = http_build_query(['q' => $this->queryString]);
        $htmlDoc = $this->getHtmlDoc(self::SEARCH_URL . $queryParams);

        $searchResults = [];
        $items = $htmlDoc->getElementsByTagName('h3');
        foreach ($items as $item) {
            /* @var $item \DOMElement */

            if ($item->getAttribute('class') != 'r'
                || $item->tagName != 'h3'
                || is_null($item->firstChild)
                || $item->firstChild->tagName != 'a') {
                continue;
            }

            $urlParts = parse_url($item->firstChild->getAttribute('href'));
            parse_str($urlParts['query'], $query);

            if (!isset($query['q']) || filter_var($query['q'], FILTER_VALIDATE_URL) === FALSE) {
                continue;
            }

            $searchResults[$query['q']] = [
                'title' => $item->firstChild->textContent,
                'url' => $query['q'],
                'source'=> [self::SOURCE]
            ];
        }

        return $searchResults;
    }

}