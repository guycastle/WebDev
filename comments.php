<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 04/06/2016
 * Time: 13:44
 */
include "php/PageBuilder.php";
$pBuilder = new PageBuilder();
if (isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"])) {
    $storage = new Storage();
    $newsItem = $storage->getNewsItem($_GET["id"]);
    if (isset($newsItem)) {
        $comments = $storage->getCommentsForNewsItem($newsItem->id);
        $pBuilder->addHead("Comments");
        $pBuilder->addNavBar(null);
        $pBuilder->addNewsComments();
    }
}
else {
    $pBuilder->buildErrorPage("Nieuws item bestaat niet");
}