<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 20/05/2016
 * Time: 00:23
 */
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
include_once "Storage.php";

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