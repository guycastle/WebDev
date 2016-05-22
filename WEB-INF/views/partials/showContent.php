<?php
$storage = new Storage();
$pictures = $storage->getPictures($show->id);
if (!isset($pictures) || !is_array($pictures) || empty($pictures)) {
    die();
}
?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $c = 0;
        foreach ($pictures as $picture) {
            if (file_exists("img/$picture->id.$picture->extension")) {
                if ($c == 0) {
                    echo "<li data-target=\"#myCarousel\" data-slide-to=\"$c\" class=\"active\"></li>";
                } else {
                    echo "<li data-target=\"#myCarousel\" data-slide-to=\"$c\"></li>";
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
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="container description">
    <div class="row">
        <div class="col-lg-6">
            <?php
            echo "<h2>Over $show->artist</h2>\n
                        <p>$show->description</p>";
            ?>
        </div>
        <div class="col-lg-6">
            <?php
            echo "<h2>Beluister</h2>\n
                        $show->spotify_embed_code";
            ?>
        </div>
    </div>
</div>
</div>

