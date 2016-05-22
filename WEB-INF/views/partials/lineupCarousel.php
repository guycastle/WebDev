<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $storage = new Storage();
        $lineup = $storage->getOrderedLineup();
        $c = 0;
        foreach ($lineup as $show) {
            if ($c == 0) {
                echo "<li data-target=\"#myCarousel\" data-slide-to=\"$c\" class=\"active\"></li>";
            } else {
                echo "<li data-target=\"#myCarousel\" data-slide-to=\"$c\"></li>";
            }
            $c++;
        }
        ?>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php
        foreach ($lineup as $show) {
            $class = "item";
            if ($lineup[0]->id == $show->id) {
                $class = "item active";
            }
            $picture = $storage->getCoverImageFor($show->id);
            if (isset($picture)) {
                echo "<div class=\"$class\">\n
                <div class='coverphoto'>
                    <a href='artists.php?id=$show->id'><img src=\"img/$picture->id.$picture->extension\" alt=\"$show->artist\"></a>\n
                    <div class=\"container\">\n
                        <div class=\"carousel-caption\">\n
                            <h1>$show->artist</h1>\n
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
