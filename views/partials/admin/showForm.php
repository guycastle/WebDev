<?php
$pattern = '^<iframe src="https:\/\/embed\.spotify\.com\/\?uri=spotify%3Aartist%3A.*" width="300" height="380" frameborder="0" allowtransparency="true"><\/iframe>$';
?>
<br>
<div class="container">
    <!-- remove special chars from PHP_SELF in order to avoid XSS-->
    <form class="form-horizontal" data-toggle="validator" id="show-form" method="post"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <div class="form-group has-feedback">
            <label for="inputArtist" class="col-offset-2 col-lg-2 control-label">Artist</label>
            <div class="input-group col-lg-8">
                <input type="text" class="form-control" name="artist" id="inputArtist"
                       placeholder="Artist" <?php echo isset($_POST["artist"]) ? "value=\"" . htmlspecialchars($_POST["artist"]) . "\"" : "" ?>
                       autofocus required data-error="Gelieve een artiestennaam in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputDescription" class="col-offset-2 col-lg-2 control-label">Beschrijving</label>
            <div class="input-group col-lg-8">
                <textarea class="form-control" name="description" id="inputDescription" rows="8"
                          placeholder="Artiestenbeschrijving hier" <?php echo isset($_POST["description"]) ? "value=\"" . htmlspecialchars($_POST["description"]) . "\"" : "" ?>
                          required data-error="Gelieve een artiestenbeschrijving in te vullen"></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputTime" class="col-offset-2 col-lg-2 control-label">Tijd</label>
            <div class="input-group col-lg-8">
                <input type="datetime-local" class="form-control" required
                       data-error="Gelieve een tijdstip in te vullen" name="time" id="inputTime">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputDay" class="col-offset-2 col-lg-2 control-label">Dag</label>
            <div class="input-group col-lg-8">
                <select required data-error="Gelieve een dag te kiezen" name="day" id="inputDay" class="form-control">
                    <option value="" disabled selected>Kies een dag</option>
                    <option value="Maandag">Maandag</option>
                    <option value="Dinsdag">Dinsdag</option>
                    <option value="Woensdag">Woensdag</option>
                    <option value="Donderdag">Donderdag</option>
                    <option value="Vrijdag">Vrijdag</option>
                    <option value="Zaterdag">Zaterdag</option>
                    <option value="Zondag">Zondag</option>
                </select>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputSpotify" class="col-offset-2 col-lg-2 control-label">Spotify Embed Code</label>
            <div class="input-group col-lg-8">
                <input type="text" class="form-control" name="spotify" id="inputSpotify" placeholder="Spotify Embed Code"
                       pattern='<?php echo SPOTIFY_PATTERN ?>' <?php echo isset($_POST["spotify"]) ? "value=\"" . htmlspecialchars($_POST["spotify"]) . "\"" : "" ?>
                       autofocus data-error="Gelieve een geldige Spotify URI in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors">Ga op Spotify, klik op "..." naast de gewenste artiest en kies "Copy
                    Spotify URI"
                </div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputImages" class="col-offset-2 col-lg-2 control-label">Afbeeldingen</label>
            <div class="input-group col-lg-8">
                <input id="inputImages" name="images[]" type="file" class="file form-control" multiple data-show-upload="false"
                       data-error="Gelieve minstens 1 afbeelding te voorzien" required accept="image/*">
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-lightgrey" id="registerButton">Opslaan</button>
            </div>
        </div>
    </form>
</div>
<!-- the main fileinput plugin file -->
<script src="/js/fileinput.min.js"></script>