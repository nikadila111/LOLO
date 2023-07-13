<?php
include 'connect.php';

if (isset($_GET['petId'])) {
    $petId = $_GET['petId'];

    // Delete attendance records first
    $deleteAttendanceQuery = "DELETE FROM attendance WHERE petId = $petId";
    $resultAttendance = mysqli_query($con, $deleteAttendanceQuery);

    // Delete the pet from the pets table
    $deletePetQuery = "DELETE FROM pets WHERE petId = $petId";
    $resultPet = mysqli_query($con, $deletePetQuery);

    if ($resultPet && $resultAttendance) {
        //echo "Deleted Successfully";
        header('location:display.php');
    } else {
        echo "Deletion Failed";
    }
}
?>
