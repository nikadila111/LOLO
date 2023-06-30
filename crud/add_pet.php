<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

if (isset($_POST['submit'])) {
    $petName = $_POST['petName'];
    $petColor = $_POST['petColor'];
    $birthDate = $_POST['birthDate'] . '-01';
    $clinicName = $_POST['clinicName'];
    $clinicPhone = $_POST['clinicPhone'];

    // Handle file uploads for vaccine card and cat image
    $vaccineCard = $_FILES['vaccineCard']['name'];
    $catImage = $_FILES['catImage']['name'];
    $vaccineCardTemp = $_FILES['vaccineCard']['tmp_name'];
    $catImageTemp = $_FILES['catImage']['tmp_name'];

    // Move uploaded files to the 'uploads' directory
    $vaccineCardPath = 'uploads/' . $vaccineCard;
    $catImagePath = 'uploads/' . $catImage;
    move_uploaded_file($vaccineCardTemp, $vaccineCardPath);
    move_uploaded_file($catImageTemp, $catImagePath);
    // Insert pet information into the "pets" table
    $sql = "INSERT INTO `pets` (petName, petColor, birthdate, vaccineCard, catImage, clinicName, clinicPhone, customer_id)
            VALUES ('$petName', '$petColor', '$birthDate', '$vaccineCard', '$catImage', '$clinicName', '$clinicPhone', '" . $_GET['id'] . "')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // "Data inserted successfully";
        header('location:display.php');
    } else {
        die(mysqli_error($con));
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

  <title>Add pet</title>
  <style>
    .preview-image {
      max-width: 200px;
      max-height: 200px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <form method="POST" enctype="multipart/form-data">
      <h2 class="my-5">Pet Information</h2>
      <div class="form-group">
        <label for="petName">Pet Name</label>
        <input type="text" class="form-control" name="petName" placeholder="Enter pet name" required>
      </div>
      <div class="form-group">
        <label for="petColor">Pet Color</label>
        <input type="text" class="form-control" name="petColor" placeholder="Enter pet color" required>
      </div>
      <div class="form-group">
        <label for="birthDate">Birth Date (month and year only)</label>
        <input type="month" class="form-control" name="birthDate" required>
      </div>

      <div class="form-group">
        <label for="vaccineCard">Vaccine Card</label>
        <input type="file" class="form-control-file" name="vaccineCard" required onchange="previewImage(event, 'vaccineCardPreview')">
        <img id="vaccineCardPreview" class="preview-image" src="" alt="Vaccine Card Preview">
      </div>
      <div class="form-group">
        <label for="catImage">Cat Image</label>
        <input type="file" class="form-control-file" name="catImage" required onchange="previewImage(event, 'catImagePreview')">
        <img id="catImagePreview" class="preview-image" src="" alt="Cat Image Preview">
      </div>

      <h2 class="my-5">Vet Details</h2>
      <div class="form-group">
        <label for="clinicName">Clinic Name</label>
        <input type="text" class="form-control" name="clinicName" placeholder="Enter clinic name" required>
      </div>
      <div class="form-group">
        <label for="clinicPhone">Phone Number</label>
        <input type="tel" class="form-control" name="clinicPhone" placeholder="Enter phone number" required>
      </div>

      <button type="submit" class="btn btn-primary my-5" name="submit">Submit</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>

  <script>
    function previewImage(event, previewId) {
      var input = event.target;
      var reader = new FileReader();
      reader.onload = function(){
        var preview = document.getElementById(previewId);
        preview.src = reader.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  </script>
</body>
</html>
