# YandexXml

Класс для работы с поисковым сервисом Яндекс.XML.

Форк https://github.com/AntonShevchuk/yandex

> Подготовлен к использованию через Composer (добавлен composer.json, заданы требования)
> Определен автолоадер (согласно psr-0)
> Класс переименован в YandexXml и перемещен в namespace AntonShevchuk\YandexXml
> Добавлен AntonShevchuk\YandexXml\Exceptions\YandexXmlException (выбрасывается в методе _checkErrors)
> Добавлены методы для проксирования запроса (если сервер с приложением не расположен на ip, заданном в настройках yandex.xml)
