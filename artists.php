<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 22/05/2016
 * Time: 01:49
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
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET["id"])) {
        $show = $storage->getShow($_GET["id"]);
        if (isset($show)) {
            $pBuilder->addHead($show->artist);
            $pBuilder->addNavBar("lineup");
            $pBuilder->addShowContent($show, $user);
            $pBuilder->addFooter();
        } else {
            $pBuilder->buildErrorPage("Deze pagina bestaat niet");
        }
    } else {
        $pBuilder->buildErrorPage("Deze pagina bestaat niet");
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($user) && $user->admin == true && isset($_POST["showId"]) && !empty($_POST["showId"])) {
        $showId = $_POST["showId"];
        //Get pictures so we can delete them after removing from the DB
        $pictures = $storage->getPictures($showId);
        if (isset($pictures) && !empty($pictures)) {
            //We can safely assume the show exists if there are pictures associated with it.
            if ($storage->deleteShow($showId)) {
                //Now delete the files from the server.
                foreach ($pictures as $picture) {
                    unlink(ROOT_PATH . "img/" . $picture->id . "." . $picture->extension);
                }
                header("Location:/");
            }
        }
    }
}