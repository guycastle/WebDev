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
$user = null;
if (isset($_SESSION["loggedIn"]) &&
    $_SESSION["loggedIn"] == true &&
    isset($_SESSION["userId"]) &&
    isset($_SESSION["email"])) {
    $user = $storage->verifyUserIdAndEmail($_SESSION["userId"], $_SESSION["email"]);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($user)) {
        if ($user->admin == true && isset($_POST["deleteNews"]) && !empty($_POST["deleteNews"]) && isset($_POST["deleteNewsId"]) && !empty($_POST["deleteNewsId"])) {
            $storage->deleteNewsItem($_POST["deleteNewsId"]);
            header("Location:/");
        }
        elseif ($user->admin == true && isset($_POST["deleteComment"]) && !empty($_POST["deleteComment"]) && isset($_POST["deleteCommentId"]) && !empty($_POST["deleteCommentId"])) {
            $storage->deleteComment($_POST["deleteCommentId"]);
            header("Location:" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "?id=" . $_POST["deleteComment"]);
        }
        else {
            $commentContent = nl2br(htmlspecialchars($_POST["content"]));
            $newsItemId = htmlspecialchars($_POST["newsItemId"]);
            if (isset($commentContent) && !empty($commentContent) && isset($newsItemId) && !empty($newsItemId)) {
                $temp = $storage->getNewsItem($newsItemId);
                if (isset($temp)) {
                    $storage->createComment($user->id, $newsItemId, $commentContent);
                }
                header("Location:/comments.php?id=" . $newsItemId);
            }
        }
    } else {
        header("Location:/login.php");
    }
}
else {
    if (isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"])) {
        $storage = new Storage();
        $newsItem = $storage->getNewsItem($_GET["id"]);
        if (isset($newsItem)) {
            $pBuilder->addHead("Comments");
            $pBuilder->addNavBar(null);
            $pBuilder->addNewsComments($newsItem, $user);
            $pBuilder->addFooter();
        }
    } else {
        $pBuilder->buildErrorPage("Nieuws item bestaat niet");
    }
}