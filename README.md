# YandexXml

Пакет для работы с поисковым сервисом Яндекс.XML.

## Установка

Данную бибилотеку можно установить с помощью менджера пакетов composer:

```
composer require anton-shevchuk/yandex-xml-library
```

## Использование


```php
<?php
require_once 'vendor/autoload.php';

use AntonShevchuk\YandexXml\Client;
use AntonShevchuk\YandexXml\Request;
use AntonShevchuk\YandexXml\Response;
use AntonShevchuk\YandexXml\Exceptions\YandexXmlException;

$request = Client::request('your-user-in-yandex-xml', 'your-key-yandex-xml');

try {
    $response = $request
        ->query('What is github query') // запрос к поисковику
        ->lr(2)                         // id региона в Яндекс {@link http://search.yaca.yandex.ru/geo.c2n}
        ->page('Начать со страницы. По умолчанию 0 (первая страница)')
        ->limit(100)                    // Количество результатов на странице (макс 100)
        ->proxy('host или ip', 'port', 'user, если требуется авторизация', 'pass, если требуется авторизация') // Если требуется проксирование запроса
        ->send()                        // Возвращает объект Response
    ;
    
    foreach ($response->results() as $i => $result) {
        echo $result->url;
        echo $result->domain;
        echo $result->title;
        echo $result->headline;
        echo sizeof($result->passages);
    }    
}
catch (YandexXmlException $e) {
    echo "\nВозникло исключение YandexXmlException:\n";
    echo $e->getMessage() . "\n";
}
catch (Exception $e) {
    echo "\nВозникло неизвестное исключение:\n";
    echo $e->getMessage() . "\n";
}

/**
 * Возвращает массив с результатами
 *
 * $results является массивом из stdClass
 * Каждый элемент содержит поля:
 *  - url
 *  - domain
 *  - title
 *  - headline
 *  - passages
 */
$results = $response->results();

/**
 * Возвращает строку "Нашлось 12 млн. результатов"
 */
$total = $response->totalHuman();

/**
 * Возвращает integer с общим количеством страниц результатов
 */
$pages = $response->pages();
```