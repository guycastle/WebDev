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

    //Returns a multidimensional associative array with the day as key, an array of shows corresponding to that day
    //as value 
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

    public function getCoverImageFor($artistId)
    {
        if ($temp = $this->mysqli->query("SELECT * FROM pictures WHERE show_id = $artistId AND cover_photo = TRUE LIMIT 1")) {
            if ($temp->num_rows > 0) {
                return $temp->fetch_object();
            } else {
                //Fallback in case no pictures have been designated as cover picture, try to get any picture for give artist
                if ($temp = $this->mysqli->query("SELECT * FROM pictures WHERE show_id = $artistId LIMIT 1")) {
                    if ($temp->num_rows > 0) {
                        return $temp->fetch_object();
                    }
                }
            }
        }
    }
}