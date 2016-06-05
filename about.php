<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 05/06/2016
 * Time: 01:05
 */
include "php/PageBuilder.php";
$pBuilder = new PageBuilder();
$pBuilder->addHead("About");
$pBuilder->addNavBar("about");
$pBuilder->addAboutContent();
$pBuilder->addFooter();