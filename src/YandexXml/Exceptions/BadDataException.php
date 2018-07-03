<?php

namespace AntonShevchuk\YandexXml\Exceptions;

/**
 * Class BadDataException to work with YandexXml
 *
 * @author   gobzer <gobzer@gmail.com>
 * @author   Anton Shevchuk <AntonShevchuk@gmail.com>
 *
 * @package  YandexXml
 */
class BadDataException extends YandexXmlException
{
    /**
     * @var string
     */
    protected $data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
