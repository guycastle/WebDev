<?php
$storage = new Storage();
$mobDetect = new Mobile_Detect();
$pictures = $storage->getPictures($show->id);
if (!isset($pictures) || !is_array($pictures) || empty($pictures)) {
    die();
}
?>
<div id="showCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $c = 0;
        foreach ($pictures as $picture) {
            if (file_exists("img/$picture->id.$picture->extension")) {
                if ($c == 0) {
                    echo "<li data-target=\"#showCarousel\" data-slide-to=\"$c\" class=\"active\"></li>";
                } else {
                    echo "<li data-target=\"#showCarousel\" data-slide-to=\"$c\"></li>";
                }
                $c++;
            }
        }
        ?>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php
        foreach ($pictures as $picture) {
            if (file_exists("img/$picture->id.$picture->extension")) {
                $class = "item";
                if ($pictures[0]->id == $picture->id) {
                    $class = "item active";
                }
                echo "<div class=\"$class\">\n
                <div class='coverphoto'>
                    <img src=\"img/$picture->id.$picture->extension\" alt=\"$show->artist\">\n
                    <div class=\"container\">\n
                        <div class=\"carousel-caption\">\n
                            <h1>$show->artist</h1>
                        </div>\n
                    </div>\n
                </div>\n
            </div>\n";
            }
        }
        ?>
    </div>
    <a class="left carousel-control" href="#showCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#showCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php
$spotify = $show->spotify_uri;
?>
<div class="container description">
    <div class="row">
        <div class="<?php echo isset($spotify) ? "col-lg-8" : "col-lg-12" ?>">
            <?php
            //Convert the DB timestamp (which is a string apparently) to a time, in order to format that to a particular
            //string and the uppercase that first letter. Not using the day property of the show object, using the actual
            //day to prevent confusion. The day property is of import for ticketing purposes, not actual timetelling
            
            $fmtTime = ucfirst(strftime("%A, %d %B om %Hu%M", strtotime($show->time)));
            echo "<h1>$fmtTime</h1>";
            echo "<h2>Over $show->artist</h2>\n
                        <p>$show->description</p>";
            if (!$mobDetect->isMobile()) {
                echo "<div class=\"addthis_sharing_toolbox\"></div>";
            }
            ?>
        </div>
        <?php
        if (isset($spotify)) {
            $encodedURI = urlencode($spotify);
            echo "<div class='col-lg-4'>\n\t
                <h2>Beluister</h2>\n\t
                <iframe src=\"https://embed.spotify.com/?uri=$encodedURI\" width=\"300\" height=\"380\" frameborder=\"0\" allowtransparency=\"true\"></iframe>\n
                </div>\n";
        }
        ?>
    </div>
</div>
</div>

