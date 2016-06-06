<div id="lineupCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $storage = new Storage();
        $lineup = $storage->getOrderedLineup();
        $c = 0;
        foreach ($lineup as $show) {
            if ($c == 0) {
                echo "<li data-target=\"lineupCarousel\" data-slide-to=\"$c\" class=\"active\"></li>";
            } else {
                echo "<li data-target=\"#lineupCarousel\" data-slide-to=\"$c\"></li>";
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
            $picture = $storage->getSingleImageFor($show->id);
            if (isset($picture) && file_exists("img/$picture->id.$picture->extension")) {
                $fmtTime = ucfirst(strftime("%A, %d %B om %Hu%M", strtotime($show->time)));
                //Description can be overly long, so let's just explode it at the first break
                $paragraph = explode("<br />", $show->description)[0];
                echo "<div class=\"$class\">\n
                <div class='coverphoto hovereffect'>                       
                    <img src=\"img/$picture->id.$picture->extension\" alt=\"$show->artist\">\n
                    <a href='artists.php?id=$show->id' class='unobtrusiveLink'><div class='overlay container'>
                    <h2>$fmtTime</h2>
                    <h4 class='col-lg-6 col-lg-offset-3'>$paragraph</h4>
                    </div></a>
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
    <a class="left carousel-control" href="#lineupCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#lineupCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
