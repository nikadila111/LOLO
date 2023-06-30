<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

// Retrieve the pet ID from the query parameter
$petId = isset($_GET['petId']) ? $_GET['petId'] : '';

if ($petId === '') {
    echo "No pet ID provided";
    exit;
}

// Construct the SQL query to retrieve the pet information
$sql = "SELECT * FROM pets WHERE petId = $petId";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Retrieve the pet information from the row
    $petName = $row['petName'];
    $petColor = $row['petColor'];
    $birthdate = $row['birthdate'];
    $vaccineCard = $row['vaccineCard'];
    $catImage = $row['catImage'];
    $clinicName = $row['clinicName'];
    $clinicPhone = $row['clinicPhone'];
} else {
    // Handle the case when no pet is found with the provided ID
    echo "No pet found with ID: $petId";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .petinfo {
            border-radius: 25px;
            border: 2px solid #73AD21;
            padding: 20px;
            width: 400px;
            margin: auto;
            text-align: center;
            margin-top: 5rem;
            margin-bottom: 5rem;
        }
        .petinfo img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }
        .buttons {
            margin-top: 1rem;
        }
        .buttons button {
            margin-right: 10px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="petinfo my-5">
            <h2>Pet Information</h2>
            <ul>
                <li>Pet Name: <?php echo $petName; ?></li>
                <li>Pet Color: <?php echo $petColor; ?></li>
                <li>Birthdate: <?php echo $birthdate; ?></li>
                <li>Vaccine Card: <img src="<?php echo "uploads/". $vaccineCard; ?>" alt="Vaccine Card"></li>
                <li>Cat Image: <img src="<?php echo "uploads/". $catImage; ?>" alt="Cat Image"></li>
                <li>Clinic Name: <?php echo $clinicName; ?></li>
                <li>Clinic Phone: <?php echo $clinicPhone; ?></li>
            </ul>
        </div>

        <div class="buttons text-center">
            <button class="btn btn-primary" onclick="window.location.href = 'update_pet.php?petId=<?php echo $petId; ?>'">Update</button>
            <button class="btn btn-danger" onclick="window.location.href = 'delete_pet.php?petId=<?php echo $petId; ?>'">Delete</button>
            <button class="btn btn-secondary" onclick="window.location.href = 'display.php'">Back</button>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
