<div class="page-header">
    <div class="navbar-wrapper">
        <div class="container">
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar"
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
                                $orderedDays = array("Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag", "Zondag");
                                $storage = new Storage();
                                $lineup = $storage->getLineupSortedByDay();
                                foreach ($lineup as $dayNumber => $shows) {
                                    echo "<li class=\"dropdown-header\">$orderedDays[$dayNumber]</li>\n";
                                    foreach ($shows as $show) {
                                        echo "<li><a href=\"/artists.php?id=$show->id\">$show->artist</a></li>\n";
                                    }
                                    if (sizeof($lineup) > 1 && end(array_keys($lineup)) != $dayNumber) {
                                        echo "<li role=\"separator\" class=\"divider\"></li>\n";
                                    }
                                }
                                ?>
                            </ul>
                            <li><a href="/about.php"<?php if ($currentPage == "about") {
                                    echo "class=\"active\"";
                                } ?>>About</a></li>
                            <li><a href="/contact.php" <?php if ($currentPage == "contact") {
                                    echo "class=\"active\"";
                                } ?>>Contact</a></li>
                            <li><a href="/tickets.php" id="navbar-tickets" <?php if ($currentPage == "tickets") {
                                    echo "class=\"active\"";
                                } ?>>
                                    Tickets <span class="glyphicon glyphicon-shopping-cart badge cart-badge" aria-hidden="true"> 1</span></a></li>
                            <?php
                            if (isset($_SESSION["loggedIn"]) && isset($_SESSION["email"]) && isset($_SESSION["userId"])) {
                                $user = $storage->verifyUserIdAndEmail($_SESSION["userId"], $_SESSION["email"]);
                                if ($user->admin == true) {
                                    if ($currentPage == "admin") {
                                        echo "<li class=\"dropdown active\">\n";
                                    } else echo "<li class=\"dropdown\">\n";
                                    ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/admin/news.php">Nieuwsitem aanmaken</a></li>
                                        <li><a href="/admin/lineup.php">Toevoegen aan lineup</a></li>
                                    </ul>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <!-- Can't get chrome to stop autofilling password fields-->
                        <?php
                        if ($currentPage != "login") {
                        ?>
                        <form class="navbar-form navbar-right" id='login-form' action="/login.php" method="post"
                              autocomplete="off" data-toggle="validator">
                            <?php
                            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && isset($_SESSION["name"]) && !empty($_SESSION["name"])) {
                                $name = $_SESSION["name"];
                                echo "<div class=\"form-group\">
                                    <div class='navbar-text'>Welkom, $name</div>
                                    <input type='hidden' value='logout' name='logout'>
                                    </div>
                                    <button type=\"submit\" class=\"btn btn-grey\">Uitloggen</button>";
                            } else {
                                echo "<div class=\"form-group has-feedback\">\n
                                        <div class='input-group'>\n
                                        <input name=\"email\" type=\"email\" placeholder=\"Email\" class=\"form-control\" id='loginEmail' required>\n
                                        <span class=\"glyphicon form-control-feedback\" aria-hidden=\"true\"></span>\n
                                    </div>\n
                                    </div>\n
                                    <div class=\"form-group has-feedback\">\n\t
                                        <div class='input-group'>\n
                                        <input name=\"password\" type=\"password\" placeholder=\"Password\" class=\"form-control\" id='loginPass' required>\n
                                        <span class=\"glyphicon form-control-feedback\" aria-hidden=\"true\"></span>\n
                                    </div>\n
                                    </div>\n
                                    <button type=\"submit\" class=\"btn btn-grey\" id='loginButton'>Log in</button>\n
                                    <a href='register.php' class='btn btn-grey'>Registreer</a>\n";
                            }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="content-container">
