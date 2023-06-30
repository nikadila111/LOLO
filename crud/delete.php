<?php 

include 'connect.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM `CRUD` WHERE id = $id";
    $result = mysqli_query($con, $sql);
    if($result){
       // echo "Deleted Successfully";
       header('location:display.php');
    }
}
?>
