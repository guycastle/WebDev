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
        foreach ($newsitems as $newsitem) {
            $fmtTime = strftime("%A, %d %B %Y om %H:%M", $newsitem->time);
            echo "<div class='well well- g'>$newsitem->content</div>\n
            <span>Gepublisceerd op $fmtTime</span>";
        }
    }
    ?>
</div>
