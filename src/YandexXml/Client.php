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
class Client
{
    /**
     * Request factory
     *
     * @param  string $user
     * @param  string $key
     * @throws YandexXmlException
     * @return Request
     */
    public static function request($user, $key)
    {
        if (empty($user) or empty($key)) {
            throw new YandexXmlException(YandexXmlException::solveMessage(YandexXmlException::EMPTY_USER_OR_KEY));
        }

        return new Request($user, $key);
    }

    /**
     * Highlight text
     *
     * @param  \simpleXMLElement $xml
     * @return string
     */
    public static function highlight($xml)
    {
        // FIXME: very strangely method
        $text = $xml->asXML();

        $text = str_replace('<hlword>', '<strong>', $text);
        $text = str_replace('</hlword>', '</strong>', $text);
        $text = strip_tags($text, '<strong>');

        return $text;
    }


    /**
     * Return page bar array
     *
     * @param  integer $total
     * @param  integer $current
     * @return array
     */
    public static function pageBar($total, $current)
    {
        $pageBar = array();

        if ($total < 10) {
            $pageBar = array_fill(0, $total, array('type' => 'link', 'text' => '%d'));
            $pageBar[$current] = array('type' => 'current', 'text' => '<b>%d</b>');
        } elseif ($total >= 10 && $current < 9) {
            $pageBar = array_fill(0, 10, array('type' => 'link', 'text' => '%d'));
            $pageBar[$current] = array('type' => 'current', 'text' => '<b>%d</b>');
        } elseif ($total >= 10 && $current >= 9) {
            $pageBar = array_fill(0, 2, array('type' => 'link', 'text' => '%d'));
            $pageBar[] = array('type' => 'text', 'text' => '..');
            $pageBar += array_fill($current - 2, 2, array('type' => 'link', 'text' => '%d'));
            if ($total > ($current + 2)) {
                $pageBar += array_fill($current, 2, array('type' => 'link', 'text' => '%d'));
            }
            $pageBar[$current] = array('type' => 'current', 'text' => '<b>%d</b>');
        }

        return $pageBar;
    }
}
