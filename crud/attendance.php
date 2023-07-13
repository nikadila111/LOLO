<?php
error_reporting(0); 

include 'connect.php';

$petId = isset($_GET['petId']) ? $_GET['petId'] : '';

if ($petId === '') {
    echo "No pet ID provided";
    exit;
}

$isAttended = false; // Define the variable with a default value

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

    // Update the actions for the current visit date
    if (isset($_POST['actions'])) {
        $actions = implode(', ', $_POST['actions']);

        $updateActionsQuery = "UPDATE attendance SET actions = '$actions' WHERE petId = $petId AND checkInDate = '$attendanceDate'";
        mysqli_query($con, $updateActionsQuery);
    }
}

// Retrieve the checked-in dates and actions for the pet
$visitDates = [];
$visitActions = [];
$visitQuery = "SELECT checkInDate, actions FROM attendance WHERE petId = $petId ORDER BY checkInDate DESC";
$visitResult = mysqli_query($con, $visitQuery);
while ($visitRow = mysqli_fetch_assoc($visitResult)) {
    $visitDates[] = $visitRow['checkInDate'];
    $visitActions[$visitRow['checkInDate']] = explode(', ', $visitRow['actions']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Attendance</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <form method="POST">
            <div class="form-group">
                <label for="attendance">Visited today?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="attendance" id="attendancePresent" value="present" <?php if ($isAttended) { echo "checked"; } ?>>
                    <label class="form-check-label" for="attendancePresent">Yes</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <br><br>

        <?php if (!empty($visitDates)): ?>
            <form method="POST">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Visit Date</th>
                            <th>Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitDates as $visitDate): ?>
                            <tr>
                                <td><?php echo $visitDate; ?></td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="actions[]" id="grooming-<?php echo $visitDate; ?>" value="grooming" <?php if (isset($visitActions[$visitDate]) && in_array('grooming', $visitActions[$visitDate])) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="grooming-<?php echo $visitDate; ?>">Grooming</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="actions[]" id="boarding-<?php echo $visitDate; ?>" value="boarding" <?php if (isset($visitActions[$visitDate]) && in_array('boarding', $visitActions[$visitDate])) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="boarding-<?php echo $visitDate; ?>">Boarding</label>
                                    </div>
                                    
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save Actions</button>
            </form>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
