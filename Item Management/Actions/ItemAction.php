<?php
include_once '../../configurations/dbConnect.php';
if (session_status() == PHP_SESSION_NONE)
session_start();
if (!isset($_SESSION['email']))
{
    header("Location: ../User/login.php");
    die();
}
class ItemAction extends DbConnect
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
    public function CreateItem($itemId,$description,$location,$coordinates,$make,$model)
    {
        if ($itemId != "") {
           
            $sql = "UPDATE `items` SET `description`='" . $description . "',`location`='" . $location . "',`coordinates`='" . $coordinates . "',`make`='" . $make . "',`model`='" . $model . "' WHERE id='" . $itemId . "'";
        } else {
     
            $sql = "INSERT INTO items(`description`, `location`,`coordinates`,`make`,`model`,`created_by`,`created_date`) values ('" . $description . "','" . $location . "','" . $coordinates . "','" . $make . "','" . $model . "','" . $_SESSION['email'] . "','" .date('Y-m-d H:i:s'). "')";

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

    public function GetItems()
    {
        $sql = "SELECT id, description,location,coordinates,make,model,created_by FROM items";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        return $result;
    }

    public function GetItemById($id)
    {
        $sql = "SELECT id, description,location,coordinates,make,model,created_by FROM items WHERE `id` = '" . $id . "'";
        // $user_data = mysqli_fetch_array($res);
        //print_r($user_data);
        $result = $this->conn->query($sql);

        $row = $result->fetch_array();
        return $row;
    }

    public function DeleteItem($itemId)
    {
        $sql = "DELETE  FROM items WHERE `id`='" . $itemId . "'";
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
