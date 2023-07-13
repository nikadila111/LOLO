<?php
include 'connect.php';

$emailError = '';
$icNumberError = '';

if(isset($_POST['submit'])){
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
    $sql = "INSERT INTO `CRUD` (`IC number`, name, email, mobile)
    VALUES ('$icNumber', '$name', '$email', '$mobile')";
    $result = mysqli_query($con, $sql);
    if($result){
      // echo "Data inserted successfully";
      header('location:display.php');
    } else {
      die(mysqli_error($con));
    }
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

    <title>Add customer</title>
  </head>
  <body>
    <div class="container my-5">
      <form method="POST">
        <div class="form-group">
          <label for="icNumber">IC Number</label>
          <input type="text" class="form-control" name="icNumber" placeholder="Enter IC Number">
          <?php if (!empty($icNumberError)): ?>
          <small class="text-danger"><?php echo $icNumberError; ?></small>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" placeholder="Enter name">
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" name="email" placeholder="Enter email">
          <?php if (!empty($emailError)): ?>
          <small class="text-danger"><?php echo $emailError; ?></small>
          <?php endif; ?>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="mobile">Mobile</label>
          <input type="tel" class="form-control" name="mobile" placeholder="Enter mobile number">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
  </body>
</html>
