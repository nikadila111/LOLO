<?php
include 'connect.php';

$id = $_GET['id'];
$emailError = '';
$icNumberError = '';

if (isset($_POST['submit'])) {
  $icNumber = $_POST['icNumber'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];

  // Validate email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = 'Invalid email address';
  }

  // Validate IC number
  if (strlen($icNumber) !== 12) {
    $icNumberError = 'IC number must have 12 digits';
  }

  if (empty($emailError) && empty($icNumberError)) {
    $sql = "UPDATE `CRUD` SET `IC number`='$icNumber', name='$name', email='$email', mobile='$mobile' WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
      // echo "Data updated successfully";
      header('location:display.php');
    } else {
      die(mysqli_error($con));
    }
  }
}

// Retrieve the existing data for the given ID
$sql = "SELECT * FROM `CRUD` WHERE id='$id'";
$result = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($result);

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <title>Edit customer</title>
  </head>
  <body>
    <div class="container my-5">
      <form method="POST">
        <div class="form-group">
          <label for="icNumber">IC Number</label>
          <input type="text" class="form-control" name="icNumber" value="<?php echo $data['IC number']; ?>">
          <?php if (!empty($icNumberError)): ?>
          <small class="text-danger"><?php echo $icNumberError; ?></small>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" value="<?php echo $data['name']; ?>">
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" name="email" value="<?php echo $data['email']; ?>">
          <?php if (!empty($emailError)): ?>
          <small class="text-danger"><?php echo $emailError; ?></small>
          <?php endif; ?>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="mobile">Mobile</label>
          <input type="tel" class="form-control" name="mobile" value="<?php echo $data['mobile']; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Update</button>
      </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
  </body>
</html>
