<?php
/**
 * Example of yandexXml usage
 */

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// Use your autoloader of choice. In this case composers.
//require __DIR__ . '/../vendor/autoload.php';

// Or without autoloader
require __DIR__ . '/../src/YandexXml/Client.php';
require __DIR__ . '/../src/YandexXml/Request.php';
require __DIR__ . '/../src/YandexXml/Response.php';
require __DIR__ . '/../src/YandexXml/Exceptions/YandexXmlException.php';

use AntonShevchuk\YandexXml\Client;
use AntonShevchuk\YandexXml\Exceptions\YandexXmlException;

/** Demo values
 */
$user = 'AntonShevchuk';
$key = '03.28303679:b340c90e875df328e6e120986c837284';
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
    $request = Client::request($user, $key);
    $response = $request
        ->setQuery('PHP библиотека Яндекс.xml')
        ->setLr($lr)
        ->setLimit(100)
        ->setProxy($proxyHost, $proxyPort, $proxyUser, $proxyPass)
        ->send()
    ;
    $total = $response->getTotalHuman();
    $pages = $response->getPages();
    
    /**
     * Output
     */
    echo "\nTotal resalts: " . $total . "\n";
    echo "\nPages: " . $pages . "\n";
    echo "\nResults: \n";
    var_dump($response->getResults());
}
catch (YandexXmlException $e) {
    echo "\nYandexXmlException occurred:\n";
    echo $e->getMessage() . "\n";
}
catch (Exception $e) {
    echo "\nAn unexpected error occurred:\n";
    echo $e->getMessage() . "\n";
}