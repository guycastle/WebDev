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
            $linkText = empty($storage->getCommentsForNewsItem($newsitem->id)) ? "Reageer" : "Bekijk reacties";
            ?>
            <div class='newsItem'><a class='unobtrusiveLink' href='<?php echo PROJECT_HOME . "comments.php?id=" . $newsitem->id;?>'><h4><?php echo $newsitem->title;?></h4></a>
                <div class='well well-lg newsWell'>
                    <p><?php echo $newsitem->content;?></p>
                </div>
                <div class='row'>
                    <h6 class='text-muted small col-lg-6 text-left'>Gepubliceerd op <?php echo $fmtTime;?></h6>
                    <a href='<?php echo PROJECT_HOME . "comments.php?id=" . $newsitem->id;?>' class='unobtrusiveLink col-lg-6 text-right'><h4><?php echo $linkText;?></h4></a>
                </div>
            </div>
    <?php
            if ($newsitem != end($newsitems)) {
                echo "<br>";
            }
        }
    }
    ?>
</div>
