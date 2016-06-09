<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 05/06/2016
 * Time: 19:28
 */
include "php/PageBuilder.php";
include "php/PaymentEngine.php";
include_once "php/PHPMailerAutoload.php";
define("SMTP_SERVER", "smtp.gmail.com");
define("SMTP_PORT", 587);
define("SMTP_SECURE", "tls");
define("SMTP_USERNAME", "ehbprojectsmailer");
//TODO - Put the password back in place after pushing to repo
define("SMTP_PASSWORD", "XXXXXXXXXXXXXXXXX");
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
            if ($amount >= $storage->getAvailableTicketsByDay($day)->available_tickets) {
                header("Location:" . PROJECT_HOME . "tickets.php");
            }
            else {
                if (!isset($_SESSION["basket"])) {
                    $basket = array();
                }
                else {
                    $basket = $_SESSION["basket"];
                }
                $basket[$day] = isset($basket[$day]) ? $basket[$day] += $amount : $amount;
                $_SESSION["basket"] = $basket;
                header("Location:" . PROJECT_HOME . "tickets.php");
            }
        }
    }
    elseif (isset($_POST["deleteFromBasket"]) && !empty($_POST["deleteFromBasket"])) {
        if (isset($_SESSION["basket"]) && !empty($_SESSION["basket"])) {
            unset($_SESSION["basket"][$_POST["deleteFromBasket"]]);
        }
        header("Location:". PROJECT_HOME . "tickets.php");
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
                            if ($reservationSuccess == true && $amount <= $storage->getAvailableTicketsByDay($day)->available_tickets) {
                                $reservationSuccess = $storage->createOrUpdateReservation($user->id, $day, $amount);
                            }
                            else {
                                $reservationSuccess = false;
                            }
                        }
                        if ($reservationSuccess == true) {
                            $mailer = new PHPMailer();
                            $mailer->isSMTP();
                            $mailer->Host = SMTP_SERVER;
                            $mailer->Port = SMTP_PORT;
                            $mailer->SMTPSecure = SMTP_SECURE;
                            $mailer->SMTPAuth = true;
                            $mailer->Username = SMTP_USERNAME;
                            $mailer->Password = SMTP_PASSWORD;

                            $message = "Dag " . $user->name . ",<br />\n<br />Je hebt deze mail ontvangen om te bevestigen dat jouw aankoop goed gelukt is.<br />\n<br />De details van jouw bestelling kan je terugvinden op de festivalsite onder \"Tickets\".<br />\n<br />We kijken alleszins uit naar jouw aanwezigheid op het festival.<br />\n<br />Tot binnenkort!";

                            $mailer->addAddress($user->email);
                            $mailer->Subject = "Aankoopsbevestiging tickets IndieGent Festival";
                            $mailer->setFrom('noreply@indiegent.be', "IndieGent");
                            $mailer->msgHTML($message);
                            $mailer->Send();
                            unset($_SESSION["basket"]);
                            header("Location:" . PROJECT_HOME . "payment.php");
                        }
                        else {
                            $paymentEngine->refund($transactionId);
                            $pBuilder->buildErrorPage("Uw bestelling kon niet correct uitgevoerd worden, en uw transactie met referentie " . $transactionId . " werd ongedaan gemaakt");
                        }
                    }
                }
            }
        }
    }
}