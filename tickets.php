<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 05/06/2016
 * Time: 19:28
 */
include "php/PageBuilder.php";
$pBuilder = new PageBuilder();
$storage = new Storage();
$user = null;
$reservedTickets = null;
if (isset($_SESSION["loggedIn"]) &&
    $_SESSION["loggedIn"] == true &&
    isset($_SESSION["userId"]) &&
    isset($_SESSION["email"])) {
    $user = $storage->verifyUserIdAndEmail($_SESSION["userId"], $_SESSION["email"]);
    if (isset($user)) {
        $reservedTickets = $storage->getReservations($user->id);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pBuilder->addHead("Tickets Bestellen");
    $pBuilder->addNavBar("tickets");
    $pBuilder->addTicketsForm($user, $reservedTickets);
    $pBuilder->addFooter();
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location:/");
}