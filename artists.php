<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 22/05/2016
 * Time: 01:49
 */
include "WEB-INF/php/pageBuilder.php";
$storage = new Storage();

if (isset($_GET["id"])) {
    $show = $storage->getShow($_GET["id"]);
    if (isset($show)) {
        addHead($show->artist);
        addNavBar("lineup");
        addShowContent($show);
        addFooter();
    } else {
        errorPage();
    }
} else {
    errorPage();
}

function errorPage()
{
    buildErrorPage("Deze pagina bestaat niet");
}
