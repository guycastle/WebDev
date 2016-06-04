<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 22/05/2016
 * Time: 01:49
 */
include "php/PageBuilder.php";
$pBuilder = new PageBuilder();
$storage = new Storage();

if (isset($_GET["id"])) {
    $show = $storage->getShow($_GET["id"]);
    if (isset($show)) {
        $pBuilder->addHead($show->artist);
        $pBuilder->addNavBar("lineup");
        $pBuilder->addShowContent($show);
        $pBuilder->addFooter();
    } else {
        $pBuilder->errorPage("Deze pagina bestaat niet");
    }
} else {
    $pBuilder->errorPage("Deze pagina bestaat niet");
}
