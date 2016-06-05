<br>
<div class="container">
    <form class="form-horizontal" data-toggle="validator" id="newspost-form" method="post"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group has-feedback">
            <label for="inputTitle" class="col-offset-2 col-lg-2 control-label">Titel</label>
            <div class="input-group col-lg-8">
                <input type="text" class="form-control" name="title" id="inputTitle"
                       placeholder="Onderwerp"
                       autofocus required data-error="Gelieve een onderwerp in te vullen">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputContent" class="col-offset-2 col-lg-2 control-label">Inhoud</label>
            <div class="input-group col-lg-8">
                <textarea class="form-control" rows="5"
                          placeholder="Inhoud hier" id="inputContent" name="content"
                          required data-error="Gelieve de inhoud in te vullen"></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-lightgrey" id="newsPostButton">Verzenden</button>
            </div>
        </div>
    </form>
</div>