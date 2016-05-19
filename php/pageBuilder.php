<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 20/05/2016
 * Time: 00:23
 */
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . "/WebDev/");

function addHead($title)
{
    include ROOT_PATH . "views/partials/head.php";
}

function addNavBar()
{
    include ROOT_PATH . "views/partials/nav.php";
}

function addFooter()
{
    include ROOT_PATH . "views/partials/footer.php";
}