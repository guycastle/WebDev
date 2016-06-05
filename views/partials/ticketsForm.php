<div class="container">
<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 05/06/2016
 * Time: 19:38
 */
    //Bit of a hassle but reservations are sorted alphabetically by name of the day, and we want chronological order
    $orderedDays = array("Maandag" => 0, "Dinsdag" => 1, "Woensdag" => 2, "Donderdag" => 3, "Vrijdag" => 4, "Zaterdag" => 5, "Zondag" => 6);
    if (isset($reservations) && !empty($reservations)) {
        $orderedReservations = array();
        foreach ($reservations as $reservation) {
            $orderedReservations[$orderedDays[$reservation->day]] = $reservation;
        }
        ksort($orderedReservations);
?>
        <h2>Gereserveerde tickets</h2>
        <div class="row">
            <div class="col-lg-offset-3 col-lg-3"><?php echo $user->name . " " . $user->surname?></div>
            <div class="col-lg-6">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Dag</th>
                        <th>Aantal Tickets</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($orderedReservations as $day) {
                        echo "<tr>\n
                                <th>$day->day</th>\n
                                <td>$day->amount</td>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } 
        $storage = new Storage()
    ?>
    
    
</div>
