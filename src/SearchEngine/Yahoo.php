<?php
namespace Ganryuzt\SearchEngineAggregator\SearchEngine;

use Ganryuzt\SearchEngineAggregator\SearchEngine;

/**
 * Class Yahoo
 * @package Ganryuzt\SearchEngineAggregator\SearchEngine
 * @author Zurich Ferdian <zurich.ferdian@gmail.com>
 */
class Yahoo extends SearchEngine
{

    const SOURCE = 'yahoo';
    const SEARCH_URL = 'https://search.yahoo.com/search?';

    /**
     * Get search results
     *
     * @return array
     */
    public function getSearchResults()
    {
        $query = http_build_query(['p' => $this->queryString]);

        $htmlDoc = $this->getHtmlDoc(self::SEARCH_URL . $query);

        $searchResults = [];
        $items = $htmlDoc->getElementsByTagName('h3');
        foreach ($items as $item) {
            /* @var $item \DOMElement */

            if ($item->getAttribute('class') != 'title') {
                continue;
            }

            if (is_null($item->firstChild) || !$item->firstChild instanceof \DOMElement) {
                continue;
            }

            $class = $item->firstChild->getAttribute('class');
            $classes = explode(' ', $class);
            if (!in_array('ac-algo', $classes)) {
                continue;
            }

            $url = $item->firstChild->getAttribute('href');
            $searchResults[$url] = [
                'title' => $item->firstChild->textContent,
                'url' => $url,
                'source'=> [self::SOURCE]
            ];
        }

        return $searchResults;
    }

}