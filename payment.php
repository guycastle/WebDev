<?php
/**
 * Created by PhpStorm.
 * User: guillaumevandecasteele
 * Date: 07/06/16
 * Time: 17:46
 */
include "php/PageBuilder.php";
$pBuilder = new PageBuilder();
header("refresh:5; URL=" . PROJECT_HOME . "/tickets.php");
$pBuilder->addHead("Betaling");
$pBuilder->addNavBar(null);
$pBuilder->addError("U wordt nu doorverwezen naar uw betalingsinstelling. Bij het succesvol uitvoeren van de betaling wordt u teruggebracht naar een overzicht van uw reservaties.");
$pBuilder->addSpinner();
$pBuilder->addFooter();