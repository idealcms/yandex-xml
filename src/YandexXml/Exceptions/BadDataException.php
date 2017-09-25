<?php

namespace AntonShevchuk\YandexXml\Exceptions;

/**
 * Class BadDataException to work with YandexXml
 *
 * @author   gobzer <gobzer@gmail.com>
 *
 * @package  YandexXml
 */
class BadDataException extends \Exception
{
  public $bad_data;
  public function __construct($bad_data,$message='', $code = 0, Exception $previous = null) {
    $this->bad_data = $bad_data;
    parent::__construct($message, $code, $previous);
  }
}
