<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 22/05/2016
 * Time: 01:49
 */
include "php/pageBuilder.php";
$storage = new Storage();
$show = $storage->getShow($_GET["id"]);
if (isset($show)) {
    addHead($show->artist);
    addNavBar("lineup");
    addShowContent($show);
} else {
    addHead("Foutmelding");
    addError("Deze pagina bestaat niet");
}
addFooter();
