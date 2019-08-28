<?php
include_once '../../configurations/dbConnect.php';
if (session_status() == PHP_SESSION_NONE)
session_start();
if (!isset($_SESSION['username']))
{
    header("Location: ../User/login.php");
    die();
}
class EventAction extends dbConnect
{
    public $error;
    public function __construct()
    {

        parent::__construct();
    }

    public function required_validation($field)
    {
        $count = 0;
        foreach ($field as $key => $value) {
            if (empty($value)) {
                $count++;
                $this->error .= "<p>" . $key . " is required</p>";
            }
        }

        if ($count == 0) {
            return true;
        }
    }

/**
 * Item created by is taken from session.
 */
    public function CreateEvent($eventId,$organization,$event_title,$event_description,$event_location,$event_presenter,$event_date,$event_type)
    {
        if ($eventId != "") {
           
            $sql = "UPDATE `events` SET `organization`='" . $organization . "',`event_title`='" . $event_title . "',`event_description`='" . $event_description . "',`event_location`='" . $event_location . "',`event_presenter`='" . $event_presenter . "',`event_date`='" . $event_date ."',`event_type`='" . $event_type ."' WHERE id='" . $eventId . "'";
        } else {
     
            $sql = "INSERT INTO events(`organization`, `event_title`,`event_description`,`event_location`,`event_presenter`,`event_date`,`event_type`,`created_by`,`created_date`) values ('" . $organization . "','" . $event_title . "','" . $event_description . "','" . $event_location . "','" . $event_presenter . "','"  . $event_date . "','" . $event_type . "','". $_SESSION['username'] . "','" .date('Y-m-d H:i:s'). "')";

        }

        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        if ($result) {

            return true;
        } else {
            $this->error = "Create Unsuccessful!";
            return false;
        }

    }

    public function GetEvents()
    {
        $sql = "SELECT * FROM events";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        return $result;
    }

    public function GetEventById($id)
    {
        $sql = "SELECT * FROM events WHERE `id` = '" . $id . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        $row = $result->fetch_array();
        return $row;
    }

    public function DeleteEvents($itemId)
    {
        $sql = "DELETE  FROM Events WHERE `id`='" . $itemId . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        return $result;
    }


    public function escape_string($value)
    {
        return $this->conn->real_escape_string($value);
    }
}
