<?php
session_start();
include "../model/dbconnection.php";

if(isset($_POST['ID'])){

    $ID = $_POST['ID'];

    $query = "DELETE FROM assigned_subject WHERE id = '$ID'";
    $query_run = mysqli_query($con, $query);

}