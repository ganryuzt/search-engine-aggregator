<?php
namespace Ganryuzt\SearchEngineAggregator;

/**
 * Interface SearchInterface
 * @package Ganryuzt\SearchEngineAggregator
 * @author Zurich Ferdian <zurich.ferdian@gmail.com>
 */
interface SearchInterface
{

    /**
     * @param $queryString
     * @return array
     */
    public function query($queryString);

}