<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 04/06/2016
 * Time: 14:30
 */
$storage = new Storage();
$comments = $storage->getCommentsForNewsItem($newsItem->id);
$fmtTime = strftime("%A, %d %B %Y om %H:%M", strtotime($newsItem->time));
$loggedIn = isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true;
$linkText = $loggedIn ?

    /*Logged in*/
    isset($comments) && empty($comments) ? "" : "<a href='#react' class='unobtrusiveLink col-lg-6 text-right'><h4>Reageer</h4></a>\n"
    :
    /*Not Logged in*/
    "<div class='col-lg-6 text-right'><a href='/login.php' class='btn btn-grey'>Registreer of log in om te reageren</a></div>\n";
?>
<br>
<div class="container">
    <div class='newsItem'><a class='unobtrusiveLink' href=''><h4><?php echo $newsItem->title ?></h4></a>
        <div class='well well-lg newsWell'>
            <p><?php echo $newsItem->content ?></p>
        </div>
        <div class='row'>
            <h6 class='text-muted small col-lg-6 text-left'>Gepubliceerd op <?php echo $fmtTime ?></h6>
            <?php echo $linkText ?>
        </div>
        <br>
        <br>
        <?php
        if (isset($comments) && !empty($comments)) {
            foreach ($comments as $comment) {
                $user = $storage->getUserById($comment->user_id)->name;
                $cmtTime = strftime("%d/%m/%y %H:%M", strtotime($comment->time));
                echo "<div class='row'>\n
                            <div class='col-lg-offset-3 col-lg-1'>\n
                                <div class='row'>\n
                                    <div class='text-justify'>$user</div>\n
                                </div>\n
                                <div class='row'>\n
                                    <h6 class='text-muted small text-left'>Geplaatst op  $cmtTime</h6>\n
                                </div>\n
                            </div>\n
                            <div class='col-lg-8 well commentWell '>$comment->content</div>\n
                        </div>\n";
                if (end($comments) != $comment) {
                    echo "<br>";
                }
            }
        }
        if ($loggedIn) {
            ?>
            <br>
            <a name="react"></a>
            <form data-toggle="validator" id="comment-form" method="post"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group has-feedback">
                    <label for="inputContent" class="col-offset-2 col-lg-2 control-label">Plaats een reactie</label>
                    <div class="input-group col-lg-8">
                        <textarea class="form-control" rows="5" placeholder="Inhoud hier" id="inputContent"
                                  name="content" required data-error="Gelieve een inhoud te voorzien"></textarea>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <input hidden name="newsItemId" value="<?php echo $newsItem->id ?>"/>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-lightgrey" id="newsPostButton">Reactie plaatsen</button>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</div>