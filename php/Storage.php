<?php

/**
 * Created by PhpStorm.
 * User: guill
 * Date: 20/05/2016
 * Time: 21:17
 */
class Storage
{
    private $mysqli;

    private $orderedDays = array("Maandag" => 0, "Dinsdag" => 1, "Woensdag" => 2, "Donderdag" => 3, "Vrijdag" => 4, "Zaterdag" => 5, "Zondag" => 6);

    public function __construct()
    {
        $this->mysqli = new mysqli("dt5.ehb.be", "AWD026", "13685479", "AWD026");
        if ($this->mysqli->connect_error) {
            die();
        }

    }

    //When passing parameters to query, use prepared statements to prevent SQL injection

    public function getShow($id)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM shows WHERE id = ?");
        $stmt->bind_param("d", $id);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }

    public function getPictures($showId)
    {
        $returnValue = array();
        $stmt = $this->mysqli->prepare("SELECT * FROM pictures WHERE show_id = ?");
        $stmt->bind_param("d", $showId);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                while ($picture = $temp->fetch_object()) {
                    array_push($returnValue, $picture);
                }
            }
        }
        return $returnValue;
    }

    public function getLineupSortedByDay()
    {
        return $this->sortLineupByDay($this->getOrderedLineup());
    }

    //Returns a multidimensional associative array with the day as key, an array of shows corresponding to that day
    //as value 

    public function getOrderedLineup()
    {
        $returnValue = array();
        if ($temp = $this->mysqli->query("SELECT * FROM shows ORDER BY day")) {
            if ($temp->num_rows > 0) {
                while ($show = $temp->fetch_object()) {
                    array_push($returnValue, $show);
                }
            }
        }
        return $returnValue;
    }

    public function verifyUserIdAndEmail($id, $email)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE email = ? AND id = ?");
        $stmt->bind_param("sd", $email, $id);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }

    public function getAdminEmails()
    {
        $returnValue = array();
        $stmt = $this->mysqli->prepare("SELECT email FROM users WHERE admin = TRUE");
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                while ($user = $temp->fetch_object()) {
                    array_push($returnValue, $user->email);
                }
            }
        }
        return $returnValue;
    }

    public function createUser($name, $surname, $email, $password)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO users(name, surname, email, password) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $surname, $email, password_hash($password, PASSWORD_DEFAULT));
        if ($stmt->execute()) {
            //return the newly created user object
            return $this->getUserByEmail($email);
        }
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }

    public function getSingleImageFor($showId)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM pictures WHERE show_id = ? LIMIT 1");
        $stmt->bind_param("d", $showId);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }

    public function getNewsItems()
    {
        $returnValue = array();
        $stmt = $this->mysqli->prepare("SELECT * FROM news_items ORDER BY time DESC");
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                while ($newsitem = $temp->fetch_object()) {
                    array_push($returnValue, $newsitem);
                }
            }
        }
        return $returnValue;
    }

    public function createNewsItem($title, $content)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO news_items(title, content, time) VALUES(?, ?, NOW())");
        $stmt->bind_param("ss", $title, $content);
        if ($stmt->execute()) {
            //return the newly created user object
            return $this->getNewsItem($this->mysqli->insert_id);
        }
    }

    public function getNewsItem($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM news_items WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }
    
    public function getCommentsForNewsItem($newsItemId) {
        $returnValue = array();
        $stmt = $this->mysqli->prepare("SELECT * FROM comments WHERE news_item_id = ? ORDER BY time ASC");
        $stmt->bind_param("d", $newsItemId);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                while ($comment = $temp->fetch_object()) {
                    array_push($returnValue, $comment);
                }
            }
        }
        return $returnValue;
    }

    public function getUserById($id)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("d", $id);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }

    public function createComment($userId, $newsItemId, $content)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO comments(user_id, news_item_id, content, time) VALUES(?, ?, ?, NOW())");
        $stmt->bind_param("dds", $userId, $newsItemId, $content);
        if ($stmt->execute()) {
            //return the newly created user object
            return $this->getComment($this->mysqli->insert_id);
        }
    }

    public function getComment($id)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->bind_param("d", $id);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }
    
    public function createShow($artist, $description, $time, $day, $spotify) {
        $stmt = $this->mysqli->prepare("INSERT INTO shows(artist, description, time, day, spotify_uri) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $artist, $description, $time, $day, $spotify);
        if ($stmt->execute()) {
            return $this->getShow($this->mysqli->insert_id);
        }
    }
    
    public function createPicture($showId, $extension) {
        $stmt = $this->mysqli->prepare("INSERT INTO pictures(show_id, extension) VALUES(?, ?)");
        $stmt->bind_param("ss", $showId, $extension);
        if ($stmt->execute()) {
            return $this->getPicture($this->mysqli->insert_id);
        }
    }
    
    public function getPicture($pictureId) {
        $stmt = $this->mysqli->prepare("SELECT * FROM pictures WHERE id = ?");
        $stmt->bind_param("d", $pictureId);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }

    public function deleteShow($showId) {
        $stmt = $this->mysqli->prepare("DELETE pictures, shows FROM shows LEFT JOIN pictures ON shows.id = pictures.show_id WHERE shows.id = ?");
        $stmt->bind_param("d", $showId);
        return $stmt->execute();
    }
    
    public function deleteNewsItem($newsItemId) {
        $stmt = $this->mysqli->prepare("DELETE news_items, comments FROM news_items LEFT JOIN comments ON comments.news_item_id = news_items.id WHERE news_items.id = ?");
        $stmt->bind_param("d", $newsItemId);
        return $stmt->execute();
    }
    
    public function deleteComment($commentId) {
        $stmt = $this->mysqli->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("d", $commentId);
        return $stmt->execute();
    }

    public function getReservations($userID) {
        $returnValue = array();
        $stmt = $this->mysqli->prepare("SELECT * FROM reservations WHERE user_id = ?");
        $stmt->bind_param("d", $userID);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                while ($reservation = $temp->fetch_object()) {
                    array_push($returnValue, $reservation);
                }
            }
        }
        return $this->sortArrayByDay($returnValue);
    }

    public function getAvailableTickets() {
        $returnValue = array();
        if ($temp = $this->mysqli->query("SELECT * FROM tickets")) {
            if ($temp->num_rows > 0) {
                while ($show = $temp->fetch_object()) {
                    array_push($returnValue, $show);
                }
            }
        }
        return $this->sortArrayByDay($returnValue);
    }

    private function sortLineupByDay($array) {
        $returnValue = array();
        foreach ($array as $show) {
            if (!isset($returnValue[$this->orderedDays[$show->day]])) {
                $returnValue[$this->orderedDays[$show->day]] = array();
            }
            array_push($returnValue[$this->orderedDays[$show->day]], $show);
        }
        ksort($returnValue);
        return $returnValue;
    }

    private function sortArrayByDay($array) {
        $returnValue = array();
        foreach ($array as $iDay) {
            $returnValue[$this->orderedDays[$iDay->day]] = $iDay;
        }
        ksort($returnValue);
        return $returnValue;
    }

    public function getAvailableTicketsByDay($day) {
        $stmt = $this->mysqli->prepare("SELECT * FROM tickets WHERE day = ?");
        $stmt->bind_param("s", $day);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            }
        }
    }
    
    public function createAvailableTickets($day) {
        $stmt = $this->mysqli->prepare("INSERT INTO tickets (day) VALUE (?)");
        $stmt->bind_param("s", $day);
        return $stmt->execute();
    }

    public function getPricelist() {
        $returnValue = array();
        if ($temp = $this->mysqli->query("SELECT day, price FROM tickets")) {
            if ($temp->num_rows > 0) {
                while ($ticket = $temp->fetch_object()) {
                    $returnValue[$ticket->day] = $ticket->price;
                }
            }
        }
        return $returnValue;
    }
    
    public function getShowCountByDay($day) {
        $stmt = $this->mysqli->prepare("SELECT id FROM shows WHERE day = ?");
        $stmt->bind_param("s", $day);
        $stmt->execute();
        return $stmt->get_result()->num_rows;
    }

    public function getReservationCountByDay($day) {
        $stmt = $this->mysqli->prepare("SELECT day FROM reservations WHERE day = ?");
        $stmt->bind_param("s", $day);
        $stmt->execute();
        return $stmt->get_result()->num_rows;
    }
    
    public function deleteTickets($day) {
        $stmt = $this->mysqli->prepare("DELETE FROM tickets WHERE day = ?");
        $stmt->bind_param("s", $day);
        return $stmt->execute();
    }

    public function createOrUpdateReservation($userId, $day, $amount) {
        $returnValue = false;
        try {
            $this->mysqli->autocommit(false);
            $stmt = $this->mysqli->prepare("UPDATE tickets SET available_tickets = available_tickets - ? WHERE day = ? AND available_tickets - ? >= 0");
            $stmt->bind_param("dsd", $amount, $day, $amount);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $stmt = $this->mysqli->prepare("INSERT INTO reservations (day, user_id, amount) VALUES (?,?,?) ON DUPLICATE KEY UPDATE amount = amount + ?");
                $stmt->bind_param("sddd", $day, $userId, $amount, $amount);
                $stmt->execute();
                $returnValue = $stmt->affected_rows > 0;
            }
            else {
                throw new mysqli_sql_exception();
            }
            $this->mysqli->commit();
        }
        catch (\mysqli_sql_exception $ex) {
            $this->mysqli->rollback();
            throw $ex;
        }
        finally {
            $this->mysqli->autocommit(true);
            return $returnValue;
        }
    }
}