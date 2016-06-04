<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 27/05/2016
 * Time: 02:18
 */
include "../php/PageBuilder.php";
$pBuilder = new PageBuilder();
$storage = new Storage();
if (!isset($_SESSION["userId"]) && !isset($_SESSION["email"])) {
    header("Location:/");
}
else {
    $user = $storage->verifyUserIdAndEmail($_SESSION["userId"], $_SESSION["email"]);
    if (isset($user) && $user->admin) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["title"]) && isset($_POST["content"]) && !empty($_POST["title"] && !empty($_POST["content"]))) {
            $newsTitle = htmlspecialchars($_POST["title"]);
            $newsContent = htmlspecialchars($_POST["content"]);
            $newsItem = $storage->createNewsItem($newsTitle, $newsContent);
            if (isset($newsItem) && !empty($newsItem)) {
                header("Location:/comments.php?id=" . $newsItem->id);
            }
        }
        $pBuilder->addHead("Admin");
        $pBuilder->addNavBar("admin");
        $pBuilder->addCreateNews();
        $pBuilder->addFooter();
    }
    else {
        header("Location:/");
    }
}