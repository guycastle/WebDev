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
                        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && isset($_SESSION["name"]) && !empty($_SESSION["name"])) {
                            $name = $_SESSION["name"];
                        ?>
                        <div class="nav navbar-nav navbar-right">
                            <form  action="/login.php" method="post" class="logout-form">
                                <button type="submit" name="logout" value="logout" class="btn-link navbar-btn-logout"><span class="glyphicon glyphicon-log-out navbar-text" aria-hidden="true"></span></button>
                            </form>
                        </div>
                        <?php
                        }
                        else {
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown" id="menuLogin">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">
                                    <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                                </a>
                                <div class="dropdown-menu" style="padding:17px;">
                                    <form id='login-form' action="/login.php" method="post" autocomplete="off" data-toggle="validator">
                                        <div class="form-group has-feedback">
                                            <div class='input-group'>
                                                <input name="email" type="email" placeholder="Email" class="form-control" id='loginEmail' required>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <div class='input-group'>
                                                <input name="password" type="password" placeholder="Password" class="form-control" id='loginPass' required>
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-grey" id='loginButton'>Log in</button>
                                        <a href='register.php' class='btn btn-grey'>Registreer</a>
                        <?php }
                        }
                        ?>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="content-container">