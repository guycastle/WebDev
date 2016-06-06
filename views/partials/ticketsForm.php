<div class="container">
<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 05/06/2016
 * Time: 19:38
 */
    if (isset($reservations) && !empty($reservations)) {
?>
        <h2>Gereserveerde tickets</h2>
        <div class="row">
            <div class="well well-lg reservationWell">
                <div class="row">
                    <div class="col-lg-6 well well-lg userWell">
                        <p>Dag <?php echo $user->name?>, dit zijn de tickets die je reeds besteld hebt.
                            Moest je nog bijkomende tickets wensen, bestel er gerust via onderstaande formulier</p>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th class="tableheading">Dag</th>
                                <th class="tableheading">Aantal tickets</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($reservations as $reservation) {
                                echo "<tr>\n
                            <td>$reservation->day</td>\n
                            <td>$reservation->amount</div>\n
                        </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
?>
    <br>
    <div class="row">
        <div class="col-lg-offset-1 col-lg-10">
            <div class="btn-group btn-group-justified">
                <?php
                foreach ($availableTickets as $dayTickets) {
                    //Create buttons of different colors depending on how many tickets are left
                    $avTckt = $dayTickets->available_tickets;
                    $buttonColor = null;
                    if ($avTckt > 8000) {
                        $buttonColor = "btn-success";
                    }
                    elseif ($avTckt > 2000) {
                        $buttonColor = "btn-primary";
                    }
                    elseif ($avTckt > 1000) {
                        $buttonColor = "btn-info";
                    }
                    elseif ($avTckt > 100) {
                        $buttonColor = "btn-warning";
                    }
                    elseif ($avTckt >= 0) {
                        $buttonColor = "btn-danger";
                    }
                    echo "<a href='#order' class='btn $buttonColor'>$dayTickets->day<br>
                        <span class='badge $buttonColor'>$avTckt beschikbaar</span>\n
                    </a>\n";
                }
                ?>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-offset-1 col-lg-10 text-center">
            <?php
            if (!isset($user)) {
                echo "<h1>Om tickets te kopen dient u ingelogd te zijn</h1>";
                echo "<a href='/login.php' class='btn btn-lg btn-grey'>Inloggen</a>";
            }
            else {
                $basket = null;
                if (!isset($_SESSION["basket"])) {
                    $basket = array();
                }
                else {
                    $basket = $_SESSION["basket"];
                }
            ?>
            <div class='row'>
                <div class='col-lg-8'>
                    <form class="form-horizontal" data-toggle="validator" id="show-form" method="post"
                          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="form-group has-feedback">
                            <label for="inputDay" class="col-offset-2 col-lg-2 control-label">Dag</label>
                            <div class="input-group col-lg-8">
                                <select required data-error="Gelieve een dag te kiezen" name="day" id="inputDay" class="form-control">
                                    <option value="" disabled selected>Kies een dag</option>
                                    <?php
                                        foreach($availableTickets as $dayTicket) {
                                            echo "<option value='$dayTicket->day' amount='$dayTicket->available_tickets'>$dayTicket->day</option>";
                                        }
                                    ?>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="inputAmount" class="col-offset-2 col-lg-2 control-label">Hoeveelheid</label>
                            <div class="input-group col-lg-8">
                                <input type="number" class="form-control" required
                                       data-error="Gelieve een geldige hoeveelheid in te geven" name="amount" id="inputAmount"
                                min="1">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
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
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<script src="/js/custom.js">