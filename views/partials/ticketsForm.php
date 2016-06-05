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
                <div class="btn-group btn-group-justified">
                    <?php
                    }
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