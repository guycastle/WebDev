<!-- remove special chars from PHP_SELF in order to avoid XSS-->
<?php
if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeat"])) {
    $name = htmlspecialchars($_POST["name"]);
    $surname = htmlspecialchars($_POST["surname"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $repeat = htmlspecialchars($_POST["repeat"]);
    if (!empty($email) && !empty($name) && !empty($surname) && !empty($password)) {
        if ($password !== $repeat) {
            $errorPresent = true;
        }
    }
} else {
    $errorPresent = true;
}

?>
<div class="container">
    <form class="form-horizontal register-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="form-group">
            <label for="inputName" class="col-offset-2 col-lg-2 control-label">Voornaam</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" name="name" id="inputName"
                       placeholder="Voornaam" <?php echo isset($_POST["name"]) ? "value=\"" . htmlspecialchars($_POST["name"]) . "\"" : "" ?>
                       required>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSurname" class="col-offset-2 col-lg-2 control-label">Familienaam</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" name="surname" id="inputSurname"
                       placeholder="Familienaam" <?php echo isset($_POST["surname"]) ? "value=\"" . htmlspecialchars($_POST["surname"]) . "\"" : "" ?>
                       required>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-offset-2 col-lg-2 control-label">E-mail</label>
            <div class="col-lg-8">
                <input type="email" class="form-control" name="email" id="inputEmail"
                       placeholder="E-mail" <?php echo isset($_POST["email"]) ? "value=\"" . htmlspecialchars($_POST["email"]) . "\"" : "" ?>
                       required>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-offset-2 col-lg-2 control-label">Paswoord</label>
            <div class="col-lg-8">
                <input type="password" class="form-control" name="password" id="inputPassword"
                       placeholder="Paswoord" <?php comparePasswords() ?> required>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword2" class="col-offset-2 col-lg-2 control-label">Paswoord</label>
            <div class="col-lg-8">
                <input type="password" class="form-control" name="repeat" id="inputPassword2"
                       placeholder="Paswoord" <?php comparePasswords() ?> required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-lightgrey">Registreer</button>
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