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
    public $results = array();

    /**
     * WordStat array
     *
     * @var array
     */
    public $wordstat = array();

    /**
     * Total results
     *
     * @var integer
     */
    public $total = null;

    /**
     * Total results in human form
     *
     * @var string
     */
    public $totalHuman = null;

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
        if (is_null($results)) {
            return $this->getResults();
        } else {
            return $this->setResults($results);
        }
    }

    /**
     * Set associated array of groups
     *
     * @param  array $results
     * @return Response
     */
    public function setResults($results)
    {
        $this->results = $results;
        return $this;
    }

    /**
     * Get associated array of groups
     *
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set/Get word stat
     *
     * @param  array $stats
     * @return Response|array
     */
    public function wordStat($stats = null)
    {
        if (is_null($stats)) {
            return $this->getWordStat();
        } else {
            return $this->setWordStat($stats);
        }
    }

    /**
     * Set word stat
     *
     * @param  array $stats
     * @return Response
     */
    public function setWordStat($stats)
    {
        $this->wordstat = $stats;
        return $this;
    }

    /**
     * Get word stat
     *
     * @return array
     */
    public function getWordStat()
    {
        return $this->wordstat;
    }

    /**
     * Set/Get total results
     *
     * @param  integer $total
     * @return Response|integer
     */
    public function total($total = null)
    {
        if (is_null($total)) {
            return $this->getTotal();
        } else {
            return $this->setTotal($total);
        }
    }

    /**
     * Set total results
     *
     * @param  integer $total
     * @return Response
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Get total results
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set/Get total results in human form
     *
     * @param  string $total
     * @return Response|string
     */
    public function totalHuman($total = null)
    {
        if (is_null($total)) {
            return $this->getTotalHuman();
        } else {
            return $this->setTotalHuman($total);
        }
    }

    /**
     * Set total results in human form
     *
     * @param  string $total
     * @return Response
     */
    public function setTotalHuman($total)
    {
        $this->totalHuman = $total;
        return $this->totalHuman;
    }

    /**
     * Get total results in human form
     *
     * @return string
     */
    public function getTotalHuman()
    {
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
        if (is_null($pages)) {
            return $this->getPages();
        } else {
            return $this->setPages($pages);
        }
    }

    /**
     * Set total pages
     *
     * @param  integer $pages
     * @return Response
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * Get total pages
     *
     * @return integer
     */
    public function getPages()
    {
        return $this->pages();
    }
}
