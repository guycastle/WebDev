<?php
/**
 * Created by PhpStorm.
 * User: guillaumevandecasteele
 * Date: 20/05/16
 * Time: 10:58
 */
echo "<div id=\"myCarousel\" class=\"carousel slide\" data-ride=\"carousel\">
<ol class=\"carousel-indicators\">";
$c = 0;
foreach ($array as $item) {
    if ($c == 0) {
        echo "<li data-target=\"#myCarousel\" data-slide-to=\"$c\" class=\"active\"></li>";
    } else {
        echo "<li data-target=\"#myCarousel\" data-slide-to=\"$c\"></li>";
    }
}