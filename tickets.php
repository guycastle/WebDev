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
        if (isset($day) && !empty($day) && isset($amount) && is_numeric($amount) && $amount <= $storage->getAvailableTicketsByDay($day)) {

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
    elseif (isset($_POST["payForBasket"]) && $_POST["payForBasket"] === "payForBasket") {
        if (isset($_POST["paymentOption"]) && !empty($_POST["paymentOption"])) {
            if (isset($_SESSION["basket"]) && ! empty($_SESSION["basket"])) {
                $basket = $_SESSION["basket"];
                //calculate total serverside
                $total = 0;
                foreach ($basket as $day => $amount) {
                    $total += $priceList[$day] * $amount;
                }
                if ($total > 0) {
                    if ($transactionId = $paymentEngine->executePayment($_POST["paymentOption"], $total)) {
                        $reservationSuccess = true;
                        foreach ($basket as $day => $amount) {
                            if ($reservationSuccess == true && $amount <= $storage->getAvailableTicketsByDay($day)) {
                                $reservationSuccess = $storage->createOrUpdateReservation($user->id, $day, $amount);
                            }
                            else {
                                $reservationSuccess = false;
                            }
                        }
                        if ($reservationSuccess == true) {
                            unset($_SESSION["basket"]);
                            //header("Location:/payment.php");
                        }
                        else {
                            $pBuilder->buildErrorPage("Uw bestelling kon niet correct uitgevoerd worden, neem contact op met een administrator");
                        }
                    }
                }
            }
        }
    }
}