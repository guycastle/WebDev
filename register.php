<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 22/05/2016
 * Time: 08:04
 */
include "php/pageBuilder.php";
//REGEX -> moet beginnen en eindigen met een letter of cijfer, enkel enkelvoudige spaties tussen woorden toegelaten
define("PATTERN", "^[\\w\\d]+([\\s][\\w\\d.'-]+)*$");
$storage = new Storage();
$emailAlreadyInUse = null;
if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeat"])) {
    $name = htmlspecialchars($_POST["name"]);
    $surname = htmlspecialchars($_POST["surname"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $repeat = htmlspecialchars($_POST["repeat"]);
    if (!empty($name) &&
        !empty($surname) &&
        !empty($password) &&
        $password === $repeat &&
        filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        //Check if email address is already in the system
        $existingUser = $storage->getUserByEmail($email);
        if (isset($existingUser)) {
            $emailAlreadyInUse = true;
        }
        $user = $storage->createUser($name, $surname, $email, $password);
        if (isset($user)) {
            $_SESSION["loggedIn"] = true;
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $user->name;
            $_SESSION["userId"] = $user->id;
            $_SESSION["surname"] = $user->surname;
            header("Location:/");
        }
    }
}
addHead("Registreer");
addNavBar(null);
addRegisterForm($emailAlreadyInUse);
addFooter();
?>
