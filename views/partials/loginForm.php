<br>
<div class="container">
    <form action="/login.php" method="post" data-toggle="validator" id="login-form">
        <div class="form-group has-feedback">
            <div class='input-group'>
                <input name="email" type="email" placeholder="Email" class="form-control" id='loginEmail' required>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="form-group has-feedback">
            <div class='input-group'>
                <input name="password" type="password" placeholder="Password" class="form-control" id='loginPass'
                       required>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="btn-group">
            <button type="submit" class="btn btn-grey" id='loginButton'>Log in</button>
            <a href='register.php' class='btn btn-grey'>Registreer</a>
        </div>
    </form>
</div>