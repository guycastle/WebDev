<!-- remove special chars from PHP_SELF in order to avoid XSS-->
<div class="container">
    <form class="form-horizontal" data-toggle="validator" id="register-form" method="post"
          action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="form-group has-feedback">
            <label for="inputName" class="col-offset-2 col-lg-2 control-label">Voornaam</label>
            <div class="input-group col-lg-8">
                <input type="text" class="form-control" name="name" id="inputName" pattern="<?php echo PATTERN ?>"
                       placeholder="Voornaam" <?php echo isset($_POST["name"]) ? "value=\"" . htmlspecialchars($_POST["name"]) . "\"" : "" ?>
                       autofocus required data-error="Gelieve een naam in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputSurname" class="col-offset-2 col-lg-2 control-label">Familienaam</label>
            <div class="input-group col-lg-8">
                <input type="text" class="form-control" name="surname" id="inputSurname" pattern="<?php echo PATTERN ?>"
                       placeholder="Familienaam" <?php echo isset($_POST["surname"]) ? "value=\"" . htmlspecialchars($_POST["surname"]) . "\"" : "" ?>
                       required data-error="Gelieve een familienaam in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback<?php echo $emailAlreadyInUse ? " has-error has-danger" : "" ?>">
            <label for="inputEmail" class="col-offset-2 col-lg-2 control-label">E-mail</label>
            <div class="input-group col-lg-8">
                <input type="email" class="form-control" name="email" id="inputEmail"
                       placeholder="E-mail" <?php echo isset($_POST["email"]) ? "value=\"" . htmlspecialchars($_POST["email"]) . "\"" : "" ?>
                       required
                       data-error="<?php echo $emailAlreadyInUse ? "Er bestaat reeds een gebruiker met dit e-mailadres" : "Gelieve een geldig e-mailadres in te vullen" ?>">
                <span class="glyphicon form-control-feedback" data-toggle="popover" data-trigger="focus"
                      aria-hidden="true"></span>
                <div
                    class="help-block with-errors"><?php echo $emailAlreadyInUse ? "Er bestaat reeds een gebruiker met dit e-mailadres" : "" ?></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputPassword" class="col-offset-2 col-lg-2 control-label">Paswoord</label>
            <div class="input-group col-lg-8">
                <input type="password" class="form-control" name="password" id="inputPassword"
                       pattern="<?php echo PATTERN ?>"
                       placeholder="Paswoord" <?php comparePasswords() ?> minlength="8"
                       required data-error="Gelieve een paswoord in te vullen van minstens 8 tekens in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputPassword2" class="col-offset-2 col-lg-2 control-label">Paswoord</label>
            <div class="input-group col-lg-8">
                <input type="password" class="form-control" data-match="#inputPassword" name="repeat"
                       id="inputPassword2" pattern="<?php echo PATTERN ?>"
                       placeholder="Paswoord" <?php comparePasswords() ?> minlength="8"
                       required data-error="Gelieve hier uw paswoord te herhalen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-lightgrey" id="registerButton">Registreer</button>
            </div>
        </div>
    </form>
</div>
<?php
//If the passwords don't match, don't bother filling in the values in the form as they will need to be deleted anyway
function comparePasswords()
{
    if (isset($_POST["password"]) && isset($_POST["repeat"]) && $_POST["password"] === $_POST["repeat"]) {
        echo "value=\"" . htmlspecialchars($_POST["password"]) . "\"";
    }
}

?>