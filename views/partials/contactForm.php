<div class="container">
    <!-- remove special chars from PHP_SELF in order to avoid XSS-->
    <form class="form-horizontal" data-toggle="validator" id="contact-form" method="post"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group has-feedback">
            <label for="inputName" class="col-offset-2 col-lg-2 control-label">Naam</label>
            <div class="input-group col-lg-8">
                <!-- if user is logged in, autofill these values with session stored variables, if not, try seeing if a failed post was made -->
                <input type="text" class="form-control" name="name" id="inputName" pattern="<?php echo PATTERN ?>"
                       placeholder="Voornaam" value="<?php echo isset($sessionName) ? $sessionName : "" ?>"
                       autofocus required data-error="Gelieve een naam in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputEmail" class="col-offset-2 col-lg-2 control-label">E-mail</label>
            <div class="input-group col-lg-8">
                <input type="email" class="form-control" name="email" id="inputEmail"
                       placeholder="E-mail" value="<?php echo isset($sessionEmail) ? $sessionEmail : "" ?>"
                       required
                       data-error="Gelieve een geldig e-mailadres in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputSubject" class="col-offset-2 col-lg-2 control-label">Onderwerp</label>
            <div class="input-group col-lg-8">
                <input type="text" class="form-control" name="subject" id="inputSubject" pattern="<?php echo PATTERN ?>"
                       placeholder="Onderwerp"
                       autofocus required data-error="Gelieve een onderwerp in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputMessage" class="col-offset-2 col-lg-2 control-label">Boodschap</label>
            <div class="input-group col-lg-8">
                <textarea class="form-control" rows="5" pattern="<?php echo PATTERN ?>"
                          placeholder="Uw boodschap hier" id="inputMessage" name="message"
                          required data-error="Gelieve een boodschap mee te geven"></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-lightgrey" id="contactButton">Verzenden</button>
            </div>
        </div>
    </form>
</div>
