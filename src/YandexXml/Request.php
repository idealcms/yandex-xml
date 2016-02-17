<?php

namespace AntonShevchuk\YandexXml;

use AntonShevchuk\YandexXml\Exceptions\YandexXmlException;

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
class Request
{
    /**
     * Base url to service
     */
    private $baseUrl = 'https://yandex.ru/search/xml';

    /**
     * User
     *
     * @var string
     */
    protected $user;

    /**
     * Key
     *
     * @var string
     */
    protected $key;

    /**
     * Query
     *
     * @var string
     */
    protected $query;

    /**
     * Request
     *
     * @var string
     */
    protected $request;

    /**
     * Host
     *
     * @var string
     */
    protected $host;

    /**
     * Site
     *
     * @var string
     */
    protected $site;

    /**
     * Domain
     *
     * @var string
     */
    protected $domain;

    /**
     * Catalog ID
     *
     * @see http://search.yaca.yandex.ru/cat.c2n
     * @var integer
     */
    protected $cat;

    /**
     * Geo ID
     *
     * @see http://search.yaca.yandex.ru/geo.c2n
     * @var integer
     */
    protected $geo;

    /**
     * Theme name
     *
     * @see http://help.yandex.ru/site/?id=1111797
     * @var integer
     */
    protected $theme;

    /**
     * lr
     *
     * @var integer
     */
    protected $lr;

    /**
     * Localization
     *  - ru - russian
     *  - uk - ukrainian
     *  - be - belarusian
     *  - kk - kazakh
     *  - tr - turkish
     *  - en - english
     *
     * @var string
     */
    protected $l10n;

    /**
     * Number of page
     *
     * @var integer
     */
    protected $page = 0;

    /**
     * Number of results per page
     *
     * @var integer
     */
    protected $limit = 10;

    /**
     * Sort By   'rlv' || 'tm'
     *
     * @see https://tech.yandex.ru/xml/doc/dg/concepts/post-request-docpage/
     * @var string
     */
    const SORT_RLV = 'rlv'; // relevance
    const SORT_TM = 'tm';  // time modification

    protected $sortBy = 'rlv';

    /**
     * Group By  '' || 'd'
     *
     * @see https://tech.yandex.ru/xml/doc/dg/concepts/post-request-docpage/
     * @var string
     */
    const GROUP_DEFAULT = '';
    const GROUP_SITE = 'd'; // group by site

    protected $groupBy = '';

    /**
     * Group mode   'flat' || 'deep' || 'wide'
     *
     * @var string
     */
    const GROUP_MODE_FLAT = 'flat';
    const GROUP_MODE_DEEP = 'deep';
    const GROUP_MODE_WIDE = 'wide';

    protected $groupByMode = 'flat';

    /**
     * Options of search
     *
     * @var array
     */
    protected $options = array(
        'maxpassages' => 2,    // from 2 to 5
        'max-title-length' => 160, //
        'max-headline-length' => 160, //
        'max-passage-length' => 160, //
        'max-text-length' => 640, //
    );

    /**
     * Proxy params
     * Default - no proxy
     * @var array
     */
    protected $proxy = array(
        'host' => '',
        'port' => 0,
        'user' => '',
        'pass' => ''
    );

    /**
     * __construct
     *
     * @param  string $user
     * @param  string $key
     */
    public function __construct($user, $key)
    {
        $this->user = $user;
        $this->key = $key;
    }

    /**
     * Set Base URL
     * @param String $baseUrl
     * @return Request
     */
    public function baseUrl($baseUrl = null)
    {
        if (is_null($baseUrl)) {
            return $this->getBaseUrl();
        } else {
            return $this->setBaseUrl($baseUrl);
        }
    }

    /**
     * Set Base URL
     * @param String $baseUrl
     * @return Request
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * Get Base URL
     * @return String
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Query string
     *
     * @param  string $query
     * @return Request|string
     */
    public function query($query = null)
    {
        if (is_null($query)) {
            return $this->getQuery();
        } else {
            return $this->setQuery($query);
        }
    }

    /**
     * Set query
     *
     * @param  string $query
     * @return Request
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Page
     *
     * @param  integer $page
     * @return Request|integer
     */
    public function page($page = null)
    {
        if (is_null($page)) {
            return $this->getPage();
        } else {
            return $this->setPage($page);
        }
    }

    /**
     * Page number
     *
     * @param  integer $page
     * @return Request
     */
    public function setPage($page)
    {
        $this->page = (int) $page;
        return $this;
    }

    /**
     * Get page
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Limit
     *
     * @param  integer $limit
     * @return Request|integer
     */
    public function limit($limit = null)
    {
        if (is_null($limit)) {
            return $this->getLimit();
        } else {
            return $this->setLimit($limit);
        }
    }

    /**
     * Set limit
     *
     * @param  integer $limit
     * @return Request
     */
    public function setLimit($limit)
    {
        $this->limit = (int) $limit;
        return $this;
    }

    /**
     * Get limit
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Host
     *
     * @param  string $host
     * @return Request|string
     */
    public function host($host = null)
    {
        if (is_null($host)) {
            return $this->getHost();
        } else {
            return $this->setHost($host);
        }
    }

    /**
     * Set host
     *
     * @param  string $host
     * @return Request
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Site
     *
     * @param  string $site
     * @return Request|string
     */
    public function site($site = null)
    {
        if (is_null($site)) {
            return $this->getSite();
        } else {
            return $this->setSite($site);
        }
    }

    /**
     * Set site
     *
     * @param  string $site
     * @return Request
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Domain
     *
     * @param  string $domain
     * @return Request|string
     */
    public function domain($domain = null)
    {
        if (is_null($domain)) {
            return $this->getDomain();
        } else {
            return $this->setDomain($domain);
        }
    }

    /**
     * Set domain
     *
     * @param  string $domain
     * @return Request
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Cat
     *
     * @param  integer $cat
     * @return Request|integer
     */
    public function cat($cat = null)
    {
        if (is_null($cat)) {
            return $this->getCat();
        } else {
            return $this->setCat($cat);
        }
    }

    /**
     * Set cat
     *
     * @param  integer $cat
     * @return Request
     */
    public function setCat($cat)
    {
        $this->cat = (int) $cat;
        return $this;
    }

    /**
     * Get cat
     *
     * @return integer
     */
    public function getCat()
    {
        return $this->cat;
    }

    /**
     * Geo
     *
     * @param  integer $geo
     * @return Request|integer
     */
    public function geo($geo = null)
    {
        if (is_null($geo)) {
            return $this->getGeo();
        } else {
            return $this->setGeo($geo);
        }
    }

    /**
     * Set geo
     *
     * @param  integer $geo
     * @return Request
     */
    public function setGeo($geo)
    {
        $this->geo = (int) $geo;
        return $this;
    }

    /**
     * Get geo
     *
     * @return integer
     */
    public function getGeo()
    {
        return $this->geo;
    }

    /**
     * Theme
     *
     * @param  string $theme
     * @return Request
     */
    public function theme($theme = null)
    {
        if (is_null($theme)) {
            return $this->getTheme();
        } else {
            return $this->setTheme($theme);
        }
    }

    /**
     * Set theme
     *
     * @param  integer $theme
     * @return Request
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Get theme
     *
     * @return integer
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * lr
     *
     * @param  integer $lr
     * @return integer|Request
     */
    public function lr($lr = null)
    {
        if (is_null($lr)) {
            return $this->getLr();
        } else {
            return $this->setLr($lr);
        }
    }

    /**
     * Set lr
     *
     * @param  integer $lr
     * @return Request
     */
    public function setLr($lr)
    {
        $this->lr = $lr;
        return $this;
    }

    /**
     * Get lr
     *
     * @return integer
     */
    public function getLr()
    {
        return $this->lr;
    }

    /**
     * Set/Get Localization
     *
     * @param  string $l10n
     * @return Request
     */
    public function l10n($l10n = null)
    {
        if (is_null($l10n)) {
            return $this->getL10n();
        } else {
            return $this->setL10n($l10n);
        }
    }

    /**
     * Set localization
     *
     * @param  string $l10n
     * @return Request
     */
    public function setL10n($l10n)
    {
        $this->l10n = $l10n;
        return $this;
    }

    /**
     * Get localization
     *
     * @return integer
     */
    public function getL10n()
    {
        return $this->l10n;
    }

    /**
     * Sort by ..
     *
     * @param  string $sortBy
     * @return Request
     */
    public function sortBy($sortBy)
    {
        if ($sortBy == self::SORT_RLV || $sortBy == self::SORT_TM) {
            $this->sortBy = $sortBy;
        }
        return $this;
    }

    /**
     * Set sort by
     *
     * @param  string $sortBy
     * @return Request
     */
    public function setSortBy($sortBy)
    {
        return $this->sortBy($sortBy);
    }

    /**
     * Get sort by
     *
     * @return string
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * Setup group by
     *
     * @param  string $groupBy
     * @param  string $mode
     * @return Request
     */
    public function groupBy($groupBy, $mode = self::GROUP_MODE_FLAT)
    {
        if ($groupBy == self::GROUP_DEFAULT || $groupBy == self::GROUP_SITE) {
            $this->groupBy = $groupBy;
            if ($groupBy == self::GROUP_DEFAULT) {
                $this->groupByMode = self::GROUP_MODE_FLAT;
            } else {
                $this->groupByMode = $mode;
            }
        }

        return $this;
    }

    /**
     * Set group by
     *
     * @param  string $groupBy
     * @param  string $mode
     * @return Request
     */
    public function setGroupBy($groupBy, $mode = self::GROUP_MODE_FLAT)
    {
        return $this->groupBy($groupBy, $mode);
    }

    /**
     * Get group by
     *
     * @return string
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * Get group by mode
     *
     * @return string
     */
    public function getGroupByMode()
    {
        return $this->groupByMode;
    }

    /**
     * Set option
     *
     * @param  string $option
     * @param  mixed $value
     * @return Request|mixed
     */
    public function option($option = null, $value = null)
    {
        if (is_null($option)) {
            return $this->getOption($option);
        } else {
            return $this->setOption($option, $value);
        }
    }

    /**
     * Set option
     *
     * @param  string $option
     * @param  mixed $value
     * @return Request
     */
    public function setOption($option, $value = null)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * Get option
     *
     * @return mixed
     */
    public function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        } else {
            return null;
        }
    }

    /**
     * Set/Get proxy fo request
     *
     * @param  string $host
     * @param  integer $port
     * @param  string $user
     * @param  string $pass
     * @return Request
     */
    public function proxy($host = '', $port = 80, $user = null, $pass = null)
    {
        if (is_null($host)) {
            return $this->getProxy();
        } else {
            return $this->setProxy($host, $port, $user, $pass);
        }
    }

    /**
     * Set proxy for request
     *
     * @param  string $host
     * @param  integer $port
     * @param  string $user
     * @param  string $pass
     * @return Request
     */
    public function setProxy($host = '', $port = 80, $user = null, $pass = null)
    {
        $this->proxy = array(
            'host' => $host,
            'port' => $port,
            'user' => $user,
            'pass' => $pass,
        );
        return $this;
    }

    /**
     * Get proxy settings
     *
     * @return Request
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * Apply proxy before each request
     * @param resource $ch
     */
    protected function applyProxy($ch)
    {
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_PROXY => $this->proxy['host'],
                CURLOPT_PROXYPORT => $this->proxy['port'],
                CURLOPT_PROXYUSERPWD => $this->proxy['user'] . ':' . $this->proxy['pass']
            )
        );
    }

    /**
     * Send request
     *
     * @throws YandexXmlException
     * @return Response
     */
    public function send()
    {
        if (empty($this->query)
            && empty($this->host)
        ) {
            throw new YandexXmlException(YandexXmlException::EMPTY_QUERY);
        }

        $xml = new \SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><request></request>");

        // add query to request
        $query = $this->getQuery();

        // if isset "host"
        if ($this->host) {
            if (is_array($this->host)) {
                $host_query = '(host:"' . join('" | host:"', $this->host) . '")';
            } else {
                $host_query = 'host:"' . $this->host . '"';
            }

            if (!empty($query) && $this->host) {
                $query .= ' ' . $host_query;
            } elseif (empty($query) && $this->host) {
                $query .= $host_query;
            }
        }

        // if isset "site"
        if ($this->site) {
            if (is_array($this->site)) {
                $site_query = '(site:"' . join('" | site:"', $this->site) . '")';
            } else {
                $site_query = 'site:"' . $this->site . '"';
            }

            if (!empty($query) && $this->site) {
                $query .= ' ' . $site_query;
            } elseif (empty($query) && $this->site) {
                $query .= $site_query;
            }
        }

        // if isset "domain"
        if ($this->domain) {
            if (is_array($this->domain)) {
                $domain_query = '(domain:' . join(' | domain:', $this->domain) . ')';
            } else {
                $domain_query = 'domain:' . $this->domain;
            }
            if (!empty($query) && $this->domain) {
                $query .= ' ' . $domain_query;
            } elseif (empty($query) && $this->domain) {
                $query .= $domain_query;
            }
        }

        // if isset "cat"
        if ($this->cat) {
            $query .= ' cat:' . ($this->cat + 9000000);
        }

        // if isset "theme"
        if ($this->theme) {
            $query .= ' cat:' . ($this->theme + 4000000);
        }

        // if isset "geo"
        if ($this->geo) {
            $query .= ' cat:' . ($this->geo + 11000000);
        }

        $xml->addChild('query', $query);
        $xml->addChild('page', $this->page);
        $groupings = $xml->addChild('groupings');
        $groupby = $groupings->addChild('groupby');
        $groupby->addAttribute('attr', $this->groupBy);
        $groupby->addAttribute('mode', $this->groupByMode);
        $groupby->addAttribute('groups-on-page', $this->limit);
        $groupby->addAttribute('docs-in-group', 1);

        $xml->addChild('sortby', $this->sortBy);
        $xml->addChild('maxpassages', $this->options['maxpassages']);
        $xml->addChild('max-title-length', $this->options['max-title-length']);
        $xml->addChild('max-headline-length', $this->options['max-headline-length']);
        $xml->addChild('max-passage-length', $this->options['max-passage-length']);
        $xml->addChild('max-text-length', $this->options['max-text-length']);

        $this->request = $xml;

        $ch = curl_init();

        $url = $this->getBaseUrl()
            . '?user=' . $this->user
            . '&key=' . $this->key;

        if ($this->lr) {
            $url .= '&lr=' . $this->lr;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml->asXML());
        curl_setopt($ch, CURLOPT_POST, true);

        if (!empty($this->proxy['host'])) {
            $this->applyProxy($ch);
        }

        $data = curl_exec($ch);

        $simpleXML = new \SimpleXMLElement($data);
        $simpleXML = $simpleXML->response;

        // check response error
        if (isset($simpleXML->error)) {
            $code = (int) $simpleXML->error->attributes()->code[0];
            $message = (string) $simpleXML->error;

            throw new YandexXmlException($message, $code);
        }

        $response = new Response();

        // results
        $results = array();
        foreach ($simpleXML->results->grouping->group as $group) {
            $res = new \stdClass();
            $res->url = (string) $group->doc->url;
            $res->domain = (string) $group->doc->domain;
            $res->title = isset($group->doc->title) ? Client::highlight($group->doc->title) : $res->url;
            $res->headline = isset($group->doc->headline) ? Client::highlight($group->doc->headline) : null;
            $res->passages = isset($group->doc->passages->passage) ? Client::highlight($group->doc->passages) : null;
            $res->sitelinks = isset($group->doc->snippets->sitelinks->link) ? Client::highlight(
                $group->doc->snippets->sitelinks->link
            ) : null;

            $results[] = $res;
        }

        // word stat
        $wordstat = preg_split('/,/', $simpleXML->wordstat);
        if (!empty($wordstat)) {
            $data = array();
            foreach ($wordstat as $word) {
                list($word, $count) = preg_split('/:/', $word);
                $data[$word] = intval(trim($count));
            }
            $response->setWordStat($data);
        }

        // total results
        $res = $simpleXML->xpath('found[attribute::priority="all"]');
        $total = (int) $res[0];
        $response->setTotal($total);

        // total in human text
        $res = $simpleXML->xpath('found-human');
        $totalHuman = $res[0];
        $response->setTotalHuman($totalHuman);

        // pages
        $response->setPages($total / $this->getLimit());

        return $response;
    }
}
