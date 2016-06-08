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
$loginURL = PROJECT_HOME . "login.php";
$linkText = $loggedIn ?
    /*Logged in*/
    isset($comments) && empty($comments) ? "" : "<a href='#react' class='unobtrusiveLink col-lg-6 text-right'><h4>Reageer</h4></a>\n"
    :
    /*Not Logged in*/
    "<div class='col-lg-6 text-right'><a href='$loginURL' class='btn btn-grey'>Registreer of log in om te reageren</a></div>\n";
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
        <?php
        if (isset($user) && $user->admin == true) {
            ?>
                <form method="post" action="<?php echo PROJECT_HOME;?>comments.php">
                    <input name="deleteNewsId" hidden value="<?php echo $newsItem->id ?>">
                    <button type="submit" name="deleteNews" value="deleteNews" class="btn btn-danger btn-lg text-justify p-l-1">Nieuwsitem met comments verwijderen</button>
                </form>
            <?php
        }
        ?>
        <br>
        <br>
        <?php
        if (isset($comments) && !empty($comments)) {
            foreach ($comments as $comment) {
                $userName = $storage->getUserById($comment->user_id)->name;
                $cmtTime = strftime("%d/%m/%y %H:%M", strtotime($comment->time));
                echo "<div class='row'>\n
                            <div class='col-lg-offset-3 col-lg-1'>\n
                                <div class='row'>\n
                                    <div class='text-justify'>$userName</div>\n
                                </div>\n
                                <div class='row'>\n
                                    <h6 class='text-muted small text-left'>Geplaatst op  $cmtTime</h6>\n
                                </div>\n
                            </div>\n
                            <div class='col-lg-8 well commentWell '>$comment->content</div>\n
                        </div>\n";
                if (isset($user) && $user->admin == true) {
                    ?>
                    <div class="row">
                        <div class="col-lg-offset-4">
                            <form method="post" action="<?php echo PROJECT_HOME;?>comments.php">
                                <input name="deleteCommentId" hidden value="<?php echo $comment->id ?>">
                                <button type="submit" name="deleteComment" value="<?php echo $comment->news_item_id?>" class="btn btn-danger btn-xs text-justify p-l-1">Verwijder commentaar</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                if (end($comments) != $comment) {
                    echo "<br>";
                }
            }
        }
        if ($loggedIn) {
            ?>
            <br>
            <div class="row">
                <a name="react"></a>
                <form data-toggle="validator" id="comment-form" method="post"
                      action="<?php echo PROJECT_HOME;?>comments.php">
                    <div class="form-group has-feedback">
                        <div class='col-lg-offset-2 col-lg-2'>
                            <label for="inputContent" class="control-label">Plaats een reactie</label>
                        </div>
                        <div class="input-group col-lg-8">
                            <textarea class="form-control" rows="5" placeholder="Inhoud hier" id="inputContent"
                                      name="content" required data-error="Gelieve een inhoud te voorzien"></textarea>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <input hidden name="newsItemId" value="<?php echo $newsItem->id ?>"/>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-lightgrey" id="newsPostButton">Reactie plaatsen</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
</div>