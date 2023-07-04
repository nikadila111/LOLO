<?php
include 'connect.php';

// Check if the 'petId' parameter is set in the URL
if (isset($_GET['petId'])) {
    $id = $_GET['petId'];

    // Fetch the existing pet data from the database
    $sql = "SELECT * FROM `pets` WHERE petId = $id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $petName = $row['petName'];
    $petColor = $row['petColor'];
    $birthDate = substr($row['birthdate'], 0, 7); // Extract only the year and month
    $clinicName = $row['clinicName'];
    $clinicPhone = $row['clinicPhone'];
} else {
    echo "Invalid pet ID";
    exit;
}

if (isset($_POST['submit'])) {
    // Retrieve the updated pet information from the form submission
    $newPetName = $_POST['petName'];
    $newPetColor = $_POST['petColor'];
    $newBirthDate = $_POST['birthDate'] . '-01';
    $newClinicName = $_POST['clinicName'];
    $newClinicPhone = $_POST['clinicPhone'];

    // Handle file uploads
    $vaccineCard = $_FILES['vaccineCard']['name'];
    $catImage = $_FILES['catImage']['name'];
    $vaccineCardTmp = $_FILES['vaccineCard']['tmp_name'];
    $catImageTmp = $_FILES['catImage']['tmp_name'];

    // Move uploaded files to the 'uploads' directory
    move_uploaded_file($vaccineCardTmp, 'uploads/' . $vaccineCard);
    move_uploaded_file($catImageTmp, 'uploads/' . $catImage);

    $updateSql = "UPDATE `pets` SET
                    petName = '$newPetName',
                    petColor = '$newPetColor',
                    birthdate = '$newBirthDate',
                    clinicName = '$newClinicName',
                    clinicPhone = '$newClinicPhone',
                    vaccineCard = '$vaccineCard',
                    catImage = '$catImage'
                WHERE petId = $id";

    $updateResult = mysqli_query($con, $updateSql);

    if ($updateResult) {
        echo "Data updated successfully";
        // header('location: display.php');
    } else {
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="petName">Pet Name</label>
                <input type="text" class="form-control" name="petName" placeholder="Enter pet name"
                    value="<?php echo isset($petName) ? htmlspecialchars($petName) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="petColor">Pet Color</label>
                <input type="text" class="form-control" name="petColor" placeholder="Enter pet color"
                    value="<?php echo isset($petColor) ? $petColor : ''; ?>">
            </div>
            <div class="form-group">
                <label for="birthDate">Birth Date (month and year only)</label>
                <input type="month" class="form-control" name="birthDate"
                    value="<?php echo isset($birthDate) ? $birthDate : ''; ?>">
            </div>
            <div class="form-group">
                <label for="vaccineCard">Vaccine Card</label>
                <input type="file" class="form-control" name="vaccineCard">
            </div>
            <div class="form-group">
                <label for="catImage">Cat Image</label>
                <input type="file" class="form-control" name="catImage">
            </div>
            <div class="form-group">
                <label for="clinicName">Clinic Name</label>
                <input type="text" class="form-control" name="clinicName" placeholder="Enter clinic name"
                    value="<?php echo isset($clinicName) ? $clinicName : ''; ?>">
            </div>
            <div class="form-group">
                <label for="clinicPhone">Phone Number</label>
                <input type="tel" class="form-control" name="clinicPhone" placeholder="Enter phone number"
                    value="<?php echo isset($clinicPhone) ? $clinicPhone : ''; ?>">
            </div>

            <button type="submit" class="btn btn-primary my-5" name="submit">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>

</html>
