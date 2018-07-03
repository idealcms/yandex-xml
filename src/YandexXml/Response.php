<?php

namespace AntonShevchuk\YandexXml;

/**
 * Class YandexXml for work with Yandex.XML
 *
 * @author   Anton Shevchuk <AntonShevchuk@gmail.com>
 * @author   Mihail Bubnov <bubnov.mihail@gmail.com>
 * @link     http://anton.shevchuk.name
 * @link     http://yandex.hohli.com
 *
 * @package  YandexXml
 */
class Response
{
    /**
     * Response in array
     *
     * @var array
     */
    protected $results = array();

    /**
     * Total results
     *
     * @var integer
     */
    protected $total = 0;

    /**
     * Total results in human form
     *
     * @var string
     */
    protected $totalHuman = '';

    /**
     * Number of total pages
     *
     * @var integer
     */
    protected $pages = 0;

    /**
     * Set/Get Results
     *
     * @param  array $results
     * @return Response|array
     */
    public function results($results = null)
    {
        return is_null($results) ? $this->results : $this->setResults($results);
    }

    /**
     * Set associated array of groups
     *
     * @param  array $results
     * @return Response
     */
    protected function setResults($results)
    {
        $this->results = $results;
        return $this;
    }

    /**
     * Set/Get total results
     *
     * @param  integer $total
     * @return Response|integer
     */
    public function total($total = null)
    {
        return is_null($total) ? $this->total : $this->setTotal($total);
    }

    /**
     * Set total results
     *
     * @param  integer $total
     * @return Response
     */
    protected function setTotal($total)
    {
        $this->total = (int)$total;
        return $this;
    }


    /**
     * Set/Get total results in human form
     *
     * @param  string $total
     * @return Response|string
     */
    public function totalHuman($total = null)
    {
        return is_null($total) ? $this->totalHuman : $this->setTotalHuman($total);
    }

    /**
     * Set total results in human form
     *
     * @param  string $total
     * @return string
     */
    protected function setTotalHuman($total)
    {
        $this->totalHuman = $total;
        return $this->totalHuman;
    }

    /**
     * Set/Get total pages
     *
     * @param integer $pages
     * @return Response|integer
     */
    public function pages($pages = null)
    {
        return is_null($pages) ? $this->pages : $this->setPages($pages);
    }

    /**
     * Set total pages
     *
     * @param  integer $pages
     * @return Response
     */
    protected function setPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }
}
