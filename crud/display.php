<?php
include 'connect.php';

// Handle search form submission
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // Construct the SQL query with search conditions
    $sql = "SELECT CRUD.*, GROUP_CONCAT(pets.petId SEPARATOR ',') AS petIds, GROUP_CONCAT(pets.petName SEPARATOR ', ') AS petNames, pets.petColor, pets.birthdate, pets.vaccineCard, pets.catImage, pets.clinicName, pets.clinicPhone
            FROM CRUD
            LEFT JOIN pets ON CRUD.id = pets.customer_id
            WHERE CRUD.name LIKE '%$search%'
            OR CRUD.`IC number` LIKE '%$search%'
            OR CRUD.mobile LIKE '%$search%'
            GROUP BY CRUD.id";
} else {
    // Default SQL query without search conditions
    $sql = "SELECT CRUD.*, GROUP_CONCAT(pets.petId SEPARATOR ',') AS petIds, GROUP_CONCAT(pets.petName SEPARATOR ', ') AS petNames, pets.petColor, pets.birthdate, pets.vaccineCard, pets.catImage, pets.clinicName, pets.clinicPhone
            FROM CRUD
            LEFT JOIN pets ON CRUD.id = pets.customer_id
            GROUP BY CRUD.id";
}

$result = mysqli_query($con, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOLO</title>


    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <style>
        .pet-names li a {
            color: red; /* Replace "red" with the desired color */
        }

        .btn-primary i.fas.fa-search {
        color: black;
    </style>
</head>
<body>
 
       
<img src="images/logo.png" alt="" style="width: 160px; height: 160px; margin-left: 50px;"><br>
 
<div class="container">
    

<div class="button-group">
    <button class="btn btn-dark my-5 hover-effect">
        <a href="user.php" class="text-light">Add Customer</a>
    </button>

    <button class="btn btn-dark my-5 hover-effect">
        <a href="user.php" class="text-light">Grooming Appointment</a>
    </button>

    <button class="btn btn-dark my-5 hover-effect">
        <a href="user.php" class="text-light">Contact</a>
    </button>
</div>

        <!-- Search form -->
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by name, IC number, or mobile">
                <div class="input-group-append">
                <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">IC Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Pets</th> <!-- Added Pets column -->
                    <th scope="col">Actions</th> <!-- Added Actions column -->
                    
                </tr>
            </thead>
            <tbody>

            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $icNumber = $row['IC number'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $mobile = $row['mobile'];

                    $pets = '';
                    if ($row['petNames'] !== null) {
                        $petIds = explode(',', $row['petIds']);
                        $petNames = explode(', ', $row['petNames']);
                        foreach ($petIds as $index => $petId) {
                            $pets .= '<a href="pet_info.php?petId=' . $petId . '">' . $petNames[$index] . '</a>, ';
                        }
                        // Remove the trailing comma and space
                        $pets = rtrim($pets, ', ');
                    } else {
                        $pets = 'No pets';
                    }

                    echo '<tr>
                        <th scope="row">' . $id . '</th>
                        <td>' . $icNumber . '</td>
                        <td>' . $name . '</td>
                        <td>' . $email . '</td>
                        <td>' . $mobile . '</td>
                        <td>' . $pets . '</td>
                        <td>
                            <a href="edit.php?id=' . $id . '" class="btn btn-primary">Edit</a>
                            <a href="delete.php?id=' . $id . '" class="btn btn-danger">Delete</a>
                            <a href="add_pet.php?id=' . $id . '" class="btn btn-success">Add <i class="fas fa-cat"></i></a>
                        </td>
                        
                    </tr>';
                }
            } else {
                echo '<tr><td colspan="7">No records found</td></tr>';
            }
            ?>
                
            </tbody>
        </table>
    </div>
</body>
</html>
