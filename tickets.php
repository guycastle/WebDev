<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 05/06/2016
 * Time: 19:28
 */
include "php/PageBuilder.php";
include "php/PaymentEngine.php";
$pBuilder = new PageBuilder();
$storage = new Storage();
$paymentEngine = new PaymentEngine();
$user = null;
$reservedTickets = null;
$availableTickets = $storage->getAvailableTickets();
$priceList = $storage->getPricelist();
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
    $pBuilder->addTicketsForm($user, $reservedTickets, $availableTickets, $priceList, $paymentEngine->getPaymentOptions());
    $pBuilder->addFooter();
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["addToBasket"]) && $_POST["addToBasket"] === "addToBasket") {
        $day = $_POST["day"];
        $amount = $_POST["amount"];
        if (isset($day) && !empty($day) && isset($amount) && !empty($amount) && is_numeric($amount) && $amount <= $storage->getAvailableTicketsByDay($day)) {

            if (!isset($_SESSION["basket"])) {
                $basket = array();
            }
            else {
                $basket = $_SESSION["basket"];
            }
            $basket[$day] = isset($basket[$day]) ? $basket[$day] += $amount : $amount;
            $_SESSION["basket"] = $basket;
            header("Location:/tickets.php");
        }
    }
    elseif (isset($_POST["deleteFromBasket"]) && !empty($_POST["deleteFromBasket"])) {
        if (isset($_SESSION["basket"]) && !empty($_SESSION["basket"])) {
            unset($_SESSION["basket"][$_POST["deleteFromBasket"]]);
        }
        header("Location:/tickets.php");
    }
}