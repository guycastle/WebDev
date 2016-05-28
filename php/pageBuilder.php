<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 20/05/2016
 * Time: 00:23
 */
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
setlocale(LC_ALL, 'nl_BE');
include_once "Storage.php";
include_once "Mobile_Detect.php";
session_start();

function addHead($title)
{
    include ROOT_PATH . "views/partials/head.php";
}

function addNavBar($currentPage)
{
    include ROOT_PATH . "views/partials/nav.php";
}

function addFooter()
{
    include ROOT_PATH . "views/partials/footer.php";
}

function addLineupCarousel()
{
    include ROOT_PATH . "views/partials/lineupCarousel.php";
}

function addShowContent($show)
{
    include ROOT_PATH . "views/partials/showContent.php";
}

function addError($message)
{
    include ROOT_PATH . "views/partials/error.php";
}

function addRegisterForm($emailAlreadyInUse)
{
    include ROOT_PATH . "views/partials/registerForm.php";
}

function buildErrorPage($message)
{
    addHead("Foutmelding");
    addNavBar(null);
    addError($message);
    addFooter();
}

function addContactForm($sessionEmail, $sessionName)
{
    include ROOT_PATH . "views/partials/contactForm.php";
}

function addNews()
{
    include ROOT_PATH . "views/partials/news.php";
}