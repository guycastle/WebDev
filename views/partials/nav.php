<div class="navbar-wrapper">
    <div class="container">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Open navigatie menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">IndieGent Festival</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php if ($currentPage == "lineup") {
                            echo "<li class=\"dropdown active\">\n";
                        } else echo "<li class=\"dropdown\">\n";
                        ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">Lineup <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                $storage = new Storage();
                                $lineup = $storage->getLineupSortedByDay();
                                foreach ($lineup as $day => $shows) {
                                    echo "<li class=\"dropdown-header\">$day</li>\n";
                                    foreach ($shows as $show) {
                                        echo "<li><a href=\"/artists.php?id=$show->id\">$show->artist</a></li>\n";
                                    }
                                    if (sizeof($lineup) > 1 && end(array_keys($lineup)) != $day) {
                                        echo "<li role=\"separator\" class=\"divider\"></li>\n";
                                    }
                                }
                                ?>
                            </ul>
                    </
                    >
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
