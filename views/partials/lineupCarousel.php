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
                $pHome = PROJECT_HOME; 
                $fmtTime = ucfirst(strftime("%A, %d %B om %Hu%M", strtotime($show->time)));
                //Description can be overly long, so let's just explode it at the first break
                $paragraph = explode("<br />", $show->description)[0];
                ?>
        <div class="<?php echo $class; ?>">
                <div class='coverphoto hovereffect'>                       
                    <img src="<?php echo PROJECT_HOME . "img/" . $picture->id . "." . $picture->extension;?>" alt="<?php echo $show->artist;?>">
                    <a href='<?php echo PROJECT_HOME . "artists.php?id=" . $show->id;?>' class='unobtrusiveLink'><div class='overlay container'>
                    <h2><?php echo $fmtTime;?></h2>
                    <h4 class='col-lg-6 col-lg-offset-3'><?php echo $paragraph;?></h4>
                    </div></a>
                    <div class="container">                   
                        <div class="carousel-caption">
                            <h1><?php echo $show->artist;?></h1>
                        </div>
                    </div>
                </div>  
            </div>
        <?php
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
