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
                    <div class="col-lg-6">
                        <p>Dag <?php echo $user->name?>, hier kan je je reeds aangekochte tickets bezichtigen.
                            Hieronder kan je zien hoeveel tickets er nog beschikbaar zijn indien je er nog wenst te bestellen
                        </p>
                    </div>
                    <div class="col-lg-6 well well-lg userWell">
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
                    if ($avTckt > 5000) {
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
                    echo "<a href='#order' class='btn $buttonColor dropdown-selector' day='$dayTickets->day'>$dayTickets->day<br>
                        <span class='badge $buttonColor'>$avTckt beschikbaar</span>\n
                    </a>\n";
                }
                ?>
            </div>
        </div>
    </div>
    <br>
    <br><br>
    <div class="row">
        <?php
        if (!isset($user)) {
            ?>
        <div class="col-lg-offset-1 col-lg-10 text-center">
            <h1>Om tickets te kopen dient u ingelogd te zijn</h1>
            <a href='<?php echo PROJECT_HOME;?>login.php' class='btn btn-lg btn-grey'>Inloggen</a>
        </div>
        <?php
        }
        else {
        ?>
        <div class='row'>
            <div class='col-lg-5'>
                <form class="form-horizontal basket-form" data-toggle="validator" id="show-form" method="post"
                      action="<?php echo PROJECT_HOME;?>tickets.php" enctype="multipart/form-data">
                    <div class="form-group has-feedback">
                        <label for="inputDay" class="col-offset-2 col-lg-2 control-label">Dag</label>
                        <div class="input-group col-lg-8 width-addon">
                            <select required data-error="Gelieve een dag te kiezen" name="day" id="inputDay"
                                    class="form-control">
                                <option value="" disabled selected>Kies een dag</option>
                                <?php
                                foreach ($availableTickets as $dayTicket) {
                                    echo $dayTicket->available_tickets > 0 ? "<option value='$dayTicket->day' amount='$dayTicket->available_tickets' price='$dayTicket->price'>$dayTicket->day</option>" : "";
                                }
                                ?>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="inputAmount" class="col-offset-2 col-lg-2 control-label">Aantal</label>
                        <div class="input-group col-lg-8 width-addon">
                            <input type="number" class="form-control" required
                                   data-error="Gelieve een geldige hoeveelheid in te geven" name="amount"
                                   id="inputAmount"
                                   min="1" placeholder="1">
                            <span class="input-group-addon " id="price">&euro;</span>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="text-center">
                            <button type="submit" class="btn btn-lightgrey" name="addToBasket" value="addToBasket" id="registerButton">Toevoegen aan
                                mandje
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
                if (isset($_SESSION["basket"]) && !empty($_SESSION["basket"])) {
                    $basket = $_SESSION["basket"];
            ?>
            <div class="col-lg-7">
                <div class="well well-lg well-basket" rows="5">
                    <table class="table table-responsive basket">
                        <thead>
                        <tr>
                            <th>Dag</th>
                            <th>Aantal</th>
                            <th>Prijs</th>
                            <th class="text-center">Verwijderen</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $total = 0;
                            foreach($basket as $day => $amount) {
                                $subTotal = $amount * $priceList[$day];
                        ?>
                            <tr class='text-left'>
                                <th><?php echo $day;?></th>
                                <td><?php echo $amount;?></td>
                                <td><?php echo $subTotal;?></td>
                                <td class='text-center'><form method='post' action='<?php echo PROJECT_HOME;?>tickets.php'><button id='basket-delete' name='deleteFromBasket' value='<?php echo $day;?>' class='btn-xs btn-link btn-danger'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></form></td>
                            </tr>
                        <?php
                            $total += $subTotal;
                        }
                        echo "<tr>
                                <th colspan='2'>Totaal:</th>
                                <td class='text-left' colspan='2'>$total&euro;</td>
                            </tr>";
                        ?>
                        </tbody>
                    </table>
                    <div class="container">
                        <form class="form-horizontal" data-toggle="validator" id="payment-form" method="post"
                              action="<?php echo PROJECT_HOME;?>tickets.php">
                            <div class="form-group has-feedback">
                                <label for="inputPaymentOption" class="col-offset-2 col-lg-2 control-label">Betaalmethode</label>
                                <div class="input-group col-lg-8">
                                    <select required data-error="Gelieve een dag te kiezen" name="paymentOption" id="inputPaymentOption"
                                            class="form-control">
                                        <option value="" disabled selected>Kies een betaalmethode</option>
                                        <?php
                                        foreach (array_keys($paymentOptions) as $paymentOption) {
                                            echo "<option value='$paymentOption'>$paymentOption</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" name="payForBasket" value="payForBasket" class="btn btn-lightgrey">Betalen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<script src="<?php echo PROJECT_HOME;?>d/js/custom.js">