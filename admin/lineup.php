<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 04/06/2016
 * Time: 17:28
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO
        }
        $pBuilder->addHead("Admin");
        $pBuilder->addNavBar("admin");
        $pBuilder->addFooter();
    }
    else {
        header("Location:/");
    }
}