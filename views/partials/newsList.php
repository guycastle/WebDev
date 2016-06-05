<br>
<div class="container">
    <?php
    /**
     * Created by PhpStorm.
     * User: guillaumevandecasteele
     * Date: 23/05/16
     * Time: 17:11
     */
    $storage = new Storage();
    $newsitems = $storage->getNewsItems();
    if (isset($newsitems) && !empty($newsitems)) {
        echo "<h1>Nieuws</h1>";
        foreach ($newsitems as $newsitem) {
            $fmtTime = strftime("%A, %d %B %Y om %H:%M", strtotime($newsitem->time));
            $commentURL = "comments.php?id=" . $newsitem->id;
            $linkText = empty($storage->getCommentsForNewsItem($newsitem->id)) ? "Reageer" : "Bekijk reacties";
            echo "<div class='newsItem'><a class='unobtrusiveLink' href=''><h4>$newsitem->title</h4></a>\n
                <div class='well well-lg newsWell'>\n
                <p>$newsitem->content</p>\n
                </div>\n
                <div class='row'>\n
                <h6 class='text-muted small col-lg-6 text-left'>Gepubliceerd op $fmtTime</h6>\n
                <a href='$commentURL' class='unobtrusiveLink col-lg-6 text-right'><h4>$linkText</h4></a> \n
                </div>\n
                </div>\n";
            if ($newsitem != end($newsitems)) {
                echo "<br>";
            }
        }
    }
    ?>
</div>
