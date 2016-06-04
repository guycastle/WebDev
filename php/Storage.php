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

    public function __construct()
    {
        $this->mysqli = new mysqli("localhost", "owner", "owner", "festival");
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
        $stmt = $this->mysqli->prepare("SELECT * FROM pictures WHERE show_id = ? ORDER BY cover_photo ASC");
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
        $returnValue = array();
        $temp = $this->getOrderedLineup();
        foreach ($temp as $show) {
            if (!isset($returnValue[$show->day])) {
                $returnValue[$show->day] = array();
            }
            array_push($returnValue[$show->day], $show);
        }
        return $returnValue;
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

    public function getCoverImageFor($showId)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM pictures WHERE show_id = ? AND cover_photo = TRUE LIMIT 1");
        $stmt->bind_param("d", $showId);
        $stmt->execute();
        if ($temp = $stmt->get_result()) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            } else {
                //Fallback in case no pictures have been designated as cover picture, try to get any picture for give artist
                $stmt = $this->mysqli->prepare("SELECT * FROM pictures WHERE show_id = ? LIMIT 1");
                $stmt->bind_param("d", $showId);
                $stmt->execute();
                if ($temp = $stmt->get_result()) {
                    if ($temp->num_rows > 0) {
                        return $temp->fetch_object();
                    }
                }
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

    public function createNewsItem($title, $content) {
        $stmt = $this->mysqli->prepare("INSERT INTO news_items(title, content, time) VALUES(?, ?, NOW())");
        $stmt->bind_param("ss", $title, $content);
        if ($stmt->execute()) {
            //return the newly created user object
            return $this->getNewsItem($this->mysqli->insert_id);
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
}