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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendanceDate = date('Y-m-d');

    // Check if the pet is already in the attendance list for today
    $attendanceQuery = "SELECT * FROM attendance WHERE petId = $petId AND checkInDate = '$attendanceDate'";
    $attendanceResult = mysqli_query($con, $attendanceQuery);
    $isAttended = mysqli_num_rows($attendanceResult) > 0;

    // Add or remove attendance based on user input
    if (isset($_POST['attendance'])) {
        $attendance = $_POST['attendance'];
        if ($attendance === 'present' && !$isAttended) {
            // Insert new attendance record for today
            $insertAttendanceQuery = "INSERT INTO attendance (petId, checkInDate) VALUES ('$petId', '$attendanceDate')";
            mysqli_query($con, $insertAttendanceQuery);
        } elseif ($attendance === 'absent' && $isAttended) {
            // Remove attendance record for today
            $deleteAttendanceQuery = "DELETE FROM attendance WHERE petId = $petId AND checkInDate = '$attendanceDate'";
            mysqli_query($con, $deleteAttendanceQuery);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://fonts.googleapis.com/css?family=Sacramento' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Modal Image */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .modal-content img {
            width: 100%;
            height: auto;
        }

        .petinfo {
            border-radius: 25px;
            border: 5px solid #f46523;
            padding: 80px;
            width: 1000px;
            margin: auto;
            text-align: center;
            margin-top: 5rem;
            margin-bottom: 5rem;
        }

        .history {
            border-radius: 25px;
            border: 5px solid #f46523;
            padding: 80px;
            width: 1100px;
            margin: auto;
            text-align: center;
            margin-top: 5rem;
            margin-bottom: 5rem;
        }

        .petinfo .cat-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #f46523;
            margin-top: 10px;
            cursor: pointer;
        }
        .petinfo .vaccine-card {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            cursor: pointer;
        }
        .buttons {
            margin-top: 1rem;
        }
        .buttons .button {
            position: relative;
            padding: 24px 64px;
            border-radius: 100vw;
            background-color: transparent;
            font-family: 'Playfair Display', serif;
            color: #1c1a1a;
            border: solid 5px rgba(244,101,35,255);
            overflow: hidden;
            cursor: pointer;
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            -webkit-mask-image: -webkit-radial-gradient(white, black);
        }
        .buttons .button .button-text {
            position: relative;
            z-index: 2;
        }
        .buttons .button .fill-container {
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            padding-bottom: 100%;
            transform: translateY(-50%) rotate(180deg);
        }
        .buttons .button .fill-container::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #f46523;
            border-radius: 50%;
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            transform: translateY(-100%);
        }
        .buttons .button:hover {
            border-color: black;
            transform: translateY(-4px);
        }
        .buttons .button:hover .fill-container {
            transform: translateY(-50%) rotate(0);
        }
        .buttons .button:hover .fill-container::after {
            transform: translateY(0);
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
            <h1 style="text-decoration: underline; font-family: 'Sacramento'; font-size: 60px;">&nbsp;&nbsp;Pet &nbsp;&nbsp;Information&nbsp;</h1><br>
            <div style="text-align: center;">
                <img class="cat-image" src="<?php echo "uploads/". $catImage; ?>" alt="Cat Image" onclick="openModal('<?php echo "uploads/". $catImage; ?>')">
            </div><br>
            <p><b>Pet Name:&nbsp;&nbsp;&nbsp;</b><?php echo $petName; ?></p>
            <p><b>Pet Color:&nbsp;&nbsp;&nbsp;</b><?php echo $petColor; ?></p>
            <p><b>Birthdate:&nbsp;&nbsp;&nbsp;</b><?php echo $birthdate; ?></p>
            <p><b>Clinic Name:&nbsp;&nbsp;&nbsp;</b><?php echo $clinicName; ?></p>
            <p><b>Clinic Phone:&nbsp;&nbsp;&nbsp;</b><?php echo $clinicPhone; ?></p>
            <p><b>Vaccine Card:&nbsp;&nbsp;&nbsp;</b><img class="vaccine-card" src="<?php echo "uploads/". $vaccineCard; ?>" alt="Vaccine Card" onclick="openModal('<?php echo "uploads/". $vaccineCard; ?>')"></p>
            <br><br>
            <div class="buttons text-center">
    <button class="button" onclick="location.href='update_pet.php?petId=<?php echo $petId; ?>'">
        <span class="button-text">Update</span>
        <div class="fill-container">
            <div class="fill"></div>
        </div>
    </button>&nbsp;&nbsp;&nbsp;
    <button class="button" onclick="location.href='delete_pet.php?petId=<?php echo $petId; ?>'">
        <span class="button-text">Delete</span>
        <div class="fill-container">
            <div class="fill"></div>
        </div>
    </button>&nbsp;&nbsp;&nbsp;
    <button class="button" onclick="location.href='display.php'">
        <span class="button-text">Back</span>
        <div class="fill-container">
            <div class="fill"></div>
        </div>
    </button>
    

</div>
        </div>
    </div>
    <!-- Modal Image -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <script>
        // Open the modal and display the clicked image
        function openModal(imageUrl) {
            var modal = document.getElementById("myModal");
            var modalImage = document.getElementById("modalImage");
            modal.style.display = "block";
            modalImage.src = imageUrl;
        }

        // Close the modal
        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>

<!--second border-->

<div class="container">
        <div class="history my-5">
            <h1 style="text-decoration: underline; font-family: 'Sacramento'; font-size: 60px;">&nbsp;&nbsp;History &nbsp;&nbsp;</h1><br>
            
         <!-- Include the attendance form from attendance.php -->
         <?php include 'attendance.php'; ?>
        </div>
    </div>

    <script>
        function toggleAttendance() {
            var attendanceSection = document.getElementById("attendanceSection");
            if (attendanceSection.style.display === "none") {
                attendanceSection.style.display = "block";
            } else {
                attendanceSection.style.display = "none";
            }
        }
    </script>
</body>
</html>