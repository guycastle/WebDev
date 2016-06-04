<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 04/06/2016
 * Time: 13:44
 */
include "php/PageBuilder.php";
$pBuilder = new PageBuilder();
$storage = new Storage();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION["loggedIn"])
        && $_SESSION["loggedIn"] == true
        && isset($_SESSION["userId"])
        && !empty($_SESSION["userId"])
    ) {
        $user = $storage->getUserById($_SESSION["userId"]);
        if (isset($user)) {
            $commentContent = htmlspecialchars($_POST["content"]);
            $newsItemId = htmlspecialchars($_POST["newsItemId"]);
            if (isset($commentContent) && !empty($commentContent) && isset($newsItemId) && !empty($newsItemId)) {
                $temp = $storage->getNewsItem($newsItemId);
                if (isset($temp)) {
                    $storage->createComment($user->id, $newsItemId, $commentContent);
                }
                header("Location:/comments.php?id=" . $newsItemId);
            }
        } else {
            header("Location:/login.php");
        }
    }
}
else {
    if (isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"])) {
        $storage = new Storage();
        $newsItem = $storage->getNewsItem($_GET["id"]);
        if (isset($newsItem)) {
            $pBuilder->addHead("Comments");
            $pBuilder->addNavBar(null);
            $pBuilder->addNewsComments($newsItem);
            $pBuilder->addFooter();
        }
    } else {
        $pBuilder->buildErrorPage("Nieuws item bestaat niet");
    }
}