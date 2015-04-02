<?php
/* 
 * Example of yandexXml usage
 * 
 */

// Use your autoloader of choice. In this case composers.
require __DIR__ . '/../vendor/autoload.php';

use AntonShevchuk\YandexXml\YandexXmlClient;
use AntonShevchuk\YandexXml\Exceptions\YandexXmlException;

/** Demo values
 */
$user = 'myuser';
$key = 'mykey';
$lr = 2; //Saint-Petersburg, Russia

/**
 * Proxy demo values
 */
$proxyHost = '';
$proxyPort = 80;
$proxyUser = '';
$proxyPass = '';

/**
 * Start the party!
 */
try {
    $yandexXml = new YandexXmlClient($user, $key);
    $results = $yandexXml
        ->setQuery('Библиотека xml')
        ->setLr($lr)
        ->setLimit(100)
        ->setProxy($proxyHost, $proxyPort, $proxyUser, $proxyPass)
        ->request()
        ->getResults()
    ;
    $total = $yandexXml->getTotalHuman();
    $pages = $yandexXml->getPages();
    
    /**
     * Output
     */
    echo "\nTotal resalts: " . $total . "\n";
    echo "\nPages: " . $pages . "\n";
    echo "\nResults: \n";
    var_dump($results);
}
catch (YandexXmlException $e) {
    echo "\nYandexXmlException occurred:\n";
    echo $e->getMessage() . "\n";
}
catch (Exception $e) {
    echo "\nAn unexpected error occurred:\n";
    echo $e->getMessage() . "\n";
}