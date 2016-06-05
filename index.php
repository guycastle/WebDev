<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 20/05/2016
 * Time: 00:23
 */
include "php/PageBuilder.php";
$pBuilder = new PageBuilder();

$pBuilder->addHead("Welkom");
$pBuilder->addNavBar("index");
$pBuilder->addLineupCarousel();
$pBuilder->addNewsList();
$pBuilder->addFooter();