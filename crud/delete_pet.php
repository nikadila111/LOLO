<?php

include 'connect.php';

if (isset($_GET['petId'])) {
    $petId = $_GET['petId'];

    $sql = "DELETE FROM `pets` WHERE petId = $petId";
    $result = mysqli_query($con, $sql);
    if ($result) {
        // echo "Deleted Successfully";
        header('location:display.php');
    }
}
?>
