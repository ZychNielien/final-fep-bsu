<?php
session_start();
include "../model/dbconnection.php";

if(isset($_POST['secID'])){

    $secID = $_POST['secID'];

    $query = "DELETE FROM section WHERE id = '$secID'";
    $query_run = mysqli_query($con, $query);

}