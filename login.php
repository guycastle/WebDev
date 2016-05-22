<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 22/05/2016
 * Time: 04:56
 */
//Check if correct method is used
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "WEB-INF/php/pageBuilder.php";
    if (isset($_POST["logout"]) && $_POST["logout"] == "logout") {
        session_unset();
        session_destroy();
        header("Location:/");
    } else {
        $storage = new Storage();
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
            buildErrorPage("U bent al ingelogd");
        }
        $email = $_POST["email"];
        $password = $_POST["password"];
        if (!isset($email) || empty($email) || !isset($password) || empty($password)) {
            buildErrorPage("E-mail en/of paswoord niet ingevuld");
        } else {
            $user = $storage->getUserByEmail($email);
            if (isset($user)) {
                if (password_verify($password, $user->password)) {
                    $_SESSION["loggedIn"] = true;
                    $_SESSION["email"] = $email;
                    $_SESSION["name"] = $user->name;
                    $_SESSION["userId"] = $user->id;
                    header("Location:/");
                } else {
                    buildErrorPage("E-mail en paswoord komen niet overeen");
                }
            } else {
                buildErrorPage("E-mail en paswoord komen niet overeen");
            }
        }
    }
}
