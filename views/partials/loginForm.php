<form action="/login.php" method="post">
    <div class="form-group has-feedback">
        <div class='input-group'>
            <input name="email" type="email" placeholder="Email" class="form-control" id='loginEmail' required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        </div>
    </div>
    <div class="form-group has-feedback">
        <div class='input-group'>\n
            <input name="password" type="password" placeholder="Password" class="form-control" id='loginPass' required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        </div>
    </div>
    <button type="submit" class="btn btn-grey" id='loginButton'>Log in</button>
</form>
<a href='register.php' class='btn btn-grey'>Registreer</a>