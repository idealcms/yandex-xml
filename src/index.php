<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['ttl'])) {
    $_SESSION['ttl'] = microtime(true);
}

require 'YandexXml/Client.php';
require 'YandexXml/Request.php';
require 'YandexXml/Response.php';
require 'YandexXml/Exceptions/YandexXmlException.php';

use AntonShevchuk\YandexXml\Client;
use AntonShevchuk\YandexXml\Request;
use AntonShevchuk\YandexXml\Exceptions\YandexXmlException;

// get "query" and "page" from request
$query = isset($_REQUEST['query'])?$_REQUEST['query']:'';
$page  = isset($_REQUEST['page']) ?$_REQUEST['page']:0;
$host  = isset($_REQUEST['host']) ?$_REQUEST['host']:null;
$geo   = isset($_REQUEST['geo']) ?$_REQUEST['geo']:null;
$cat   = isset($_REQUEST['cat']) ?$_REQUEST['cat']:null;
$theme = isset($_REQUEST['theme']) ?$_REQUEST['theme']:null;

// small protection for example script
// only 2 seconds
if ($query && (microtime(true) - $_SESSION['ttl']) > 2) {
    // Your data http://xmlsearch.yandex.ru/xmlsearch?user=AntonShevchuk&key=03.28303679:b340c90e875df328e6e120986c837284
    $user = 'AntonShevchuk';
    $key  = '03.28303679:b340c90e875df328e6e120986c837284';

    try {
        // Create new instance of Yandex class
        $request = Client::request($user, $key);

        // Set Query
        $response = $request->query($query)
            ->host($host)// set one host or multihost
            //-> host(array('anton.shevchuk.name','cotoha.info'))
            //-> site(array('anton.shevchuk.name','cotoha.info'))
            //-> domain(array('ru','org'))
            ->page($page)                       // set current page
            ->limit(10)                         // set page limit
            ->geo($geo)                         // set geo region - http://search.yaca.yandex.ru/geo.c2n
            ->cat($cat)                         // set category - http://search.yaca.yandex.ru/cat.c2n
            ->l10n('en')                        // set localization ru, uk, be, kk, tr, en
            ->theme($theme)                     // set theme - http://help.yandex.ru/site/?id=1111797
            ->sortBy(Request::SORT_RLV)
            ->groupBy(Request::GROUP_DEFAULT)
            ->option('max-title-length', 160)   // set some options
            ->option('max-passage-length', 200)
            ->send()                            // send request
        ;
    } catch (YandexXmlException $e) {
        $error = $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

/*
// response mock
$res = new stdClass();

$res->url = (string) 'http://anton.shevchuk.name';
$res->domain = (string) 'anton.shevchuk.name';
$res->title = 'Антон Шевчуг: <hlword>Блог</hlword> резработчика';
$res->headline = '<hlword>Блог</hlword> о web разработке';
$res->passages = array(
    'lorem ipsum omar hayam <hlword>blog</hlword> lorem dor',
    'lorem ipsum omar hayam',
    'lorem ipsum omar hayam',
);

$response = new \AntonShevchuk\YandexXml\Response();
$response->setResults([
    $res, $res, $res
]);
$response->setPages(1);
$response->setTotal(3);
$response->setTotalHuman('Three');
*/

$uri = parse_url($_SERVER['REQUEST_URI']);
$url = (isset($uri['path']))?$uri['path']:'';

// current URL
function generateUrl($params) {
    global $url, $query, $host, $geo, $cat, $theme;
    return $url .'?'. http_build_query(array_merge(array(
        'query' => $query,
        'host' => $host,
        'geo' => $geo,
        'cat' => $cat,
        'theme' => $theme
    ), $params));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yandex XML Search</title>
    <meta name="keywords" content="Yandex XML, PHP, PHP5" />
    <meta name="description" content="Yandex XML Search for PHP" />
    <link rel="profile" href="http://gmpg.org/xfn/11"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-7269638-9']);
        _gaq.push(['_setDomainName', '.hohli.com']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <style>
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 60px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            background-color: #f5f5f5;
        }
        .container {
            width: auto;
            max-width: 800px;
            padding: 0 15px;
        }
        .container .text-muted {
            margin-top: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1>
            <img height="36" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAsCAMAAACkN+1nAAABqlBMVEUAAAADAwMGBgYJCQkMDAwPDw8SEhIVFRUYGBgbGxseHh4hISEkJCQnJycqKiotLS0wMDAzMzM2NjY5OTk8PDw/Pz9CQkJFRUVISEhLS0tOTk5RUVFUVFRXV1daWlpdXV1gYGBjY2NmZmZpaWlsbGxvb29ycnJ4eHh7e3t+fn6BgYGEhISHh4eKioqNjY2QkJCTk5OWlpaZmZmcnJyfn5+ioqKlpaWoqKirq6uurq6xsbG0tLS3t7e6urq9vb3AwMDDw8PGxsbJycnMzMzPz8/S0tLV1dXY2Njb29ve3t7h4eHk5OTn5+fq6urt7e3w8PDz8/P29vb5+fn8/Pz/AAD/AwP/Bgb/CQn/DAz/Dw//EhL/FRX/GBj/Gxv/Hh7/ISH/JCT/Jyf/MDD/MzP/Pz//QkL/SEj/S0v/Tk7/UVH/YGD/Zmb/aWn/bGz/cnL/dXX/eHj/e3v/fn7/hIT/jY3/k5P/lpb/mZn/nJz/n5//paX/q6v/rq7/tLT/w8P/xsb/z8//1dX/2Nj/29v/3t7/4eH/5OT/7e3/8PD/8/P/9vb/+fn//Pz////dxpC1AAADeUlEQVR42u3V6VcTZxSA8WfIrlIbFCS0TSUUKBBToCGEpYhQCSKGhIyttZVaaWv3zbrQTW3rWu7/3DvJTAayDB7PmXP84PNlkpNkfufOO/MGqfb49vXtD0ztqvhQDblz2bT7yDfke9Pqs+0tH5HbKnzyxyORW/4hDz40zWsPRXxFfjTNi/fFX2RXF/1r8Rm5qyuy4zdyU5H7fiM/KPLUb+RbReQ5kPXsWLYo7drMj03kyy7SPMkURMUqBlNSLYXdCak1GgACWbEqB2BGj5UEdIrVfAwt/NaGjfykyN/7kQkIiVUIJqRaErvjUm2IWnOibQA5PeaAvGjTBtWMgo3s2HeXN/IGROLxsIPMAcPz3RAt70GOwjHRCkFILGQPMyw28kCRrw5EEli/SDpIHFIiF0Iw7iKzwKJofXBkU6Q0VnIQ+Vyf+LvPgIy6yDKwLNX3CRfpgj7RzgKzDdvKXzrK1j8HID1wykWGISbauxDYdJAFZw0G4ZA0ILp56clv/OuJHIOsi+i7XtFOAysO0gMDYnUY+psQ+c60a490wnwdqRgwJNoqMGsjSxA8L1oRmGhG5LcrjUhg0ipQ/3oEluvIOSAj2howZSN9MCJWi8BCC6S6S366veUidg5SBtbryHvAoSPuFywkBdGS2AtFoRXypWleeiS32iIrEJE6MouTiwQgVBSrDLDWAvlTB/lFFGl3uWagx0VyQG/qeLxavoakO+BtsRppjexeM83Lj73urlEYcpFpYE6c7DXph+C6jbS6XHpy84Z4IQnIucg8kG9ECgYMOpfrdBPyRO+tj594IZUQRtFF3gfeaUSsDzvO1/ZwJpuQn3WQX8ULWYRecZFNA5JNyIoB/faukmxEHl4yzStPPZEBmK4jWheENhoReR2MVR07CKFSA/KNDnJTvJByhM7KXiQDpBoQd4STwOB+5N5F3R//80TGISs2EhdtPQj0VxoQ6QPjrMgZtLHKXuQLHeSOeCClbj28GrcKo6+sm/cUWiSZ6nkltgdZAl6zRyH2Zqormq4h1nN4ddcLWWN/aXsmu4KLyAlgSaTcjZ2SGtf1L+t3qbWjz6RokxAVqzBMtkYkHQRrLuvkpQ6YEW0pDAlRZagDzeg/V0PkwCxEnAYcRErTmczcqrSpmEuPL26IPD/yzL1gyIUAR8VpBCPvA9LcS+Ql8gIh/wO4jFzH/PtOVAAAAABJRU5ErkJggg==" alt="Яндекс" border="0" />
            XML
        </h1>
    </div>

    <div class="jumbotron">
        <div class="container">
            <p>
                Демонстрация работы библиотеки с сервисом <a href="https://xml.yandex.ru">Яндекс.XML</a><br/>
                Последняя версия всегда доступна на <a href="https://github.com/AntonShevchuk/yandex">GitHub</a>
            </p>
        </div>
    </div>
    <?php if (isset($error)) :?>
        <div class="alert alert-danger" role="alert"><?php echo $error?></div>
    <?php endif; ?>
    <form class="form-horizontal">
        <div class="form-group media">
            <label for="query" class="col-sm-2 control-label media-right">
                Запрос
            </label>
            <div class="col-sm-8">
                <input type="text" id="query" name="query"  class="form-control" value="<?php echo $query;?>"/>
            </div>
            <div class="col-sm-2">
                <input type="submit" class="btn btn-defaults" name="search" value="Поиск"/>
            </div>
        </div>

        <div class="form-group">
            <label for="geo" class="col-sm-2 control-label">Регион</label>
            <div class="col-sm-4">
                <select id="geo" name="geo" class="form-control">
                    <option value="">Все</option>
                    <optgroup label="Город">
                        <option value="213" <?php if ($geo == 213) echo 'selected="selected"'?>>Москва</option>
                        <option value="2"   <?php if ($geo == 2)   echo 'selected="selected"'?>>Санкт-Петербург</option>
                        <option value="143" <?php if ($geo == 143) echo 'selected="selected"'?>>Киев</option>
                        <option value="157" <?php if ($geo == 157) echo 'selected="selected"'?>>Минск</option>
                    </optgroup>
                    <optgroup label="Страна">
                        <option value="225" <?php if ($geo == 225) echo 'selected="selected"'?>>Россия</option>
                        <option value="187" <?php if ($geo == 187) echo 'selected="selected"'?>>Украина</option>
                        <option value="149" <?php if ($geo == 149) echo 'selected="selected"'?>>Беларусь</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="cat" class="col-sm-2 control-label">Категория</label>
            <div class="col-sm-4">
                <select id="cat" name="cat" class="form-control">
                    <option value="">Все</option>
                    <option value="5"    <?php if ($cat == 5) echo 'selected="selected"'?>>Интернет</option>
                    <option value="3795" <?php if ($cat == 3795) echo 'selected="selected"'?>>Кино</option>
                    <option value="3796" <?php if ($cat == 3796) echo 'selected="selected"'?>>Музыка</option>
                    <option value="3797" <?php if ($cat == 3797) echo 'selected="selected"'?>>Литература</option>
                    <option value="3798" <?php if ($cat == 3798) echo 'selected="selected"'?>>Фото</option>
                </select>
            </div>
        </div>

        <input type="hidden" name="host"  value="<?php echo $host ?>"/>
        <input type="hidden" name="theme" value="<?php echo $theme ?>"/>
    </form>
</div>


<div class="container">
    <?php if (isset($request, $response)) : $start = $request->limit()*$request->page() + 1; ?>

    <div class="result box">

            <a href="http://www.yandex.ru/"><img class="inline-block" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAAVCAYAAAAJiM14AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAi5JREFUeNrcV4txwjAMNTkGSDfIBmWDhglKJ2g6AXQC0gmACaATFCYIGxAmIBuQDVKneaYPnY35tNdLdSdMZFm29GQpUQpUKRVqnmuuJKu2EZzZkBMZP7fRIYPMTnMEWdxKh4COQSYheWsdsh68rQ51FVJMU/kH+0fgAnwN9TSHBxs6/CmQ2J+BUNZMqZiM1c97sUkKObPUmYj5hOZGkGV4DrG+wpyRZcJGFuiftVGoGqVLKBSjpDpquUVngIPVWTGFbE7ZIu2NCIUpBSSGbAFZLotCeiFCMUXHhlDq0NmIaH+I51QgtBMoRmQz4tQLOsdRGmuN0RVIXYpqD/+XGLcYHy36Cd2zBcnM+uKAjvalTjmlnXol4xPka3bDoR8wrh2XmFPSpWdojPHFYn9rq3IKTj1VDfQD5HYhNlci9W6pbJx6PYezilI7F06HIiAHCrjBkoGZalBzkdkg9xw6PzFXCudOFZdIzPW8DlEl4TvlotrZvsPpkHK+9ATlrkmOI2Zaw05IBcOF9rdDeH8bGnQ6tzXZ2HMvcqHnozeMQ0LJ2L53ITS+AB0fmUq18jhk+pGPljgXo1S41gdAJ/khdIytgqqmTEdutnNCKrKlEJyZCZRWtGYOWVMD8O3z9erD/efKxlp5OLOss82nJ159UnGWI+4iAnVOvgt0CshLS7qUJ3Rc9ycW8330PG6yM0cVLVGAnqkHPeGqJIT8+y98jTg/N6ob+9dZFKh/Rp8CDABtZRlp2V86pgAAAABJRU5ErkJggg==" alt="Яндекс" border="0"/></a>
        <p>
            <?php echo $response->totalHuman() ?>
        </p>
    </div>

    <ol class="list-group" start="<?php echo $start; ?>">
    <?php foreach ($response->results() as $i => $result) :?>
        <?php
            /*
            $result is Object with next properties:
                ->url
                ->domain
                ->title
                ->headline
                ->passages // array
                ->sitelinks // array
            */
        ?>
        <li class="list-group-item">
            <span class="badge"><?php echo $start+$i; ?></span>
            <a href="<?php echo $result->url; ?>" title="<?php echo $result->url; ?>" class="list-group-item-heading">
                <h4><?php echo Client::highlight($result->title); ?></h4>
            </a>
            <div class="list-group-item-text">
                <?php if ($result->headline) : ?>
                <p>
                    <?php echo $result->headline; ?>
                </p>
                <?php endif; ?>
                <?php if ($result->passages) : ?>
                <ul>
                    <?php foreach ($result->passages as $passage) :?>
                    <li><?php echo Client::highlight($passage);?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif; ?>
                <p class="text-muted">
                    <a href="<?php echo $result->url; ?>" class="host" title="<?php echo $result->url; ?>"><?php echo $result->domain; ?></a>
                    <a href="<?php echo generateUrl(array('query'=>$query, 'host'=> $result->domain))?>" class="host" title="Поиск на сайте <?php echo $result->domain; ?>">ещё</a>
                </p>
            </div>
        </li>
    <?php endforeach;?>
    </ol>

    <nav>
        <ul class="pagination">
        <?php foreach (Client::pageBar($response->pages(), $request->page()) as $type => $value) : ?>
            <li>
            <?php
            // switch statement for $value['type']
            switch (true) {
                case ('prev' === $type && is_int($value)):
                    echo '<li><a href="'. generateUrl(array('page'=>$value)) .'" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                    break;
                case ('prev' === $type && !$value):
                    echo '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                    break;
                case ('prev-dots' === $type && $value):
                case ('next-dots' === $type && $value):
                    echo '<li class="disabled"><span><span aria-hidden="true">..</span></span></li>';
                    break;
                case ('current' === $type):
                    echo '<li class="active"><a href="#">'. $value .'<span class="sr-only">(current)</span></a></li>';
                    break;
                case ('next' === $type && is_int($value)):
                    echo '<li><a href="'. generateUrl(array('page'=>$value)) .'" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                    break;
                case ('next' === $type && !$value):
                    echo '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                    break;
                case (is_int($type)):
                    echo '<li><a href="'. generateUrl(array('page'=>$type)) .'">'. $value .'</a></li>';
                    break;
            }
            ?>
            </li>
        <?php endforeach;?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<div class="container">
    <p>Для установки с помощью composer используйте следующий код</p>
    <pre><code>composer require anton-shevchuk/yandex-xml-library</code></pre>
    <p>
        Для организации поиска по регионам или категориям смотрите коды на следующих страницах:
    </p>
    <ul>
        <li><a href="http://search.yaca.yandex.ru/geo.c2n">Коды регионов</a></li>
        <li><a href="http://search.yaca.yandex.ru/cat.c2n">Коды рубрик</a></li>
    </ul>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            &copy; 2008-<?php echo date('Y') ?> <a href="http://anton.shevchuk.name" title="Anton Shevchuk">Anton Shevchuk</a><br/>
            Поиск реализован на основе <a href="http://xml.yandex.ru/" title="Яндекс.XML">Яндекс.XML</a>
        </p>
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
