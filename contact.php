<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 23/05/2016
 * Time: 01:25
 */
//Tutorial: https://www.formget.com/send-email-via-gmail-smtp-server-in-php/
include "php/PageBuilder.php";
include "php/PHPMailerAutoload.php";
$pBuilder = new PageBuilder();
define("PATTERN", "^[\\w\\d]+([\\s][\\w\\d.'-]+)*$");
define("SMTP_SERVER", "smtp.gmail.com");
define("SMTP_PORT", 587);
define("SMTP_SECURE", "tls");
define("SMTP_USERNAME", "ehbprojectsmailer");
//TODO - Put the password back in place after pushing to repo
define("SMTP_PASSWORD", "XXXXXXXXXXXXXX");

$sessionName = null;
$sessionEmail = null;

$mailer = new PHPMailer();
if (isset($_SESSION["userId"]) && isset($_SESSION["name"]) && isset($_SESSION["surname"])) {
    $sessionName = $_SESSION["name"] . " " . $_SESSION["surname"];
    $sessionEmail = $_SESSION["email"];
}
$success = false;
if (isset($_POST["name"]) &&
    isset($_POST["email"]) &&
    isset($_POST["subject"]) &&
    isset($_POST["message"]) &&
    filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = nl2br(htmlspecialchars($_POST["message"]));

    $storage = new Storage();
    $emails = $storage->getAdminEmails();

    if (isset($emails) && !empty($emails)) {
        //Mail client configuration
        $mailer->isSMTP();
        $mailer->Host = SMTP_SERVER;
        $mailer->Port = SMTP_PORT;
        $mailer->SMTPSecure = SMTP_SECURE;
        $mailer->SMTPAuth = true;
        $mailer->Username = SMTP_USERNAME;
        $mailer->Password = SMTP_PASSWORD;

        $message = $name . " (" . $email . ") has sent you a message with the following content:\n\r\n" . $message;

        foreach ($emails as $adminEmail) {
            $mailer->addAddress($adminEmail);
            $mailer->Subject = $subject;
            $mailer->setFrom($email, $name);
            $mailer->msgHTML($message);
            if ($mailer->Send()) {
                $success = true;
            }
        }

    }
}
$pBuilder->addHead("Contact");
$pBuilder->addNavBar("contact");
if ($success) {
    $pBuilder->addError("Uw boodschap werd verzonden");
} else {
    echo "<h1>$mailer->ErrorInfo</h1>";
    $pBuilder->addContactForm($sessionEmail, $sessionName);
}
$pBuilder->addFooter();