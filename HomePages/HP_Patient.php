<?php
// Include the database connection file
require_once __DIR__ . "/../Database/database.php";

// Start session
session_start();
// Get the patient ID from the session
$patientID = $_SESSION['id'];

// Establish the database connection
$con = database_connect();



// Retrieve the patient's information from the database using their MRN
$stmt = $con->prepare('SELECT Patient_Name, Patient_Birthdate, Patient_History, Patient_Email, Patient_Gender, Patient_Address, Patient_Phone FROM Patients WHERE Patient_MRN = ?');
$stmt->bind_param('i', $patientID);
$stmt->execute();
$stmt->bind_result($patientName, $patientBirthdate, $patientHistory, $patientEmail, $patientGender, $patientAddress, $patientPhone);
$stmt->fetch();
$stmt->close();

// Book Appointment
if (isset($_POST['book-appointment'])) {
    // Get the form data
    $appointmentDate = $_POST['appointment-date'];
    $appointmentTime = $_POST['appointment-time'];
    $patientId = $_SESSION['id'];
    $doctorId = $_POST['doctor-id'];

    // Perform database insert
    $conn = database_connect();
    $query = "INSERT INTO appointments (Appointments_Date, Appointments_Time, Appointments_status, Patient_Appointement_ID, Doctor_App_ID) VALUES ('$appointmentDate', '$appointmentTime', 'booked', '$patientId', '$doctorId')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Clinic Appointments</title>
    <link rel="stylesheet" type="text/css" href="../css/HP_Patient.css">
</head>
<body>

<h1>Patient Dashboard</h1>

<div class="patient-section">

    <div class="book-appointment">
        <h3>Book an Appointment</h3>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="appointment-date">Date:</label>
            <input type="date" name="appointment-date" id="appointment-date" required>
            <label for="appointment-time">Time:</label>
            <input type="time" name="appointment-time" id="appointment-time" required>
            <label for="doctor-id">Doctor:</label>
            <select name="doctor-id" id="doctor-id" required>
                <?php
                // Retrieve the list of doctors from the database
                $conn = database_connect();
                $query = "SELECT * FROM doctors";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['Doctor_ID'] . '">' . $row['Doctor_Name'] . '</option>';
                }

                mysqli_close($conn);
                ?>
            </select>

            <input type="submit" name="book-appointment" value="Book Appointment">
        </form>
    </div>

    <div class="appointment-list">
        <h3>My Appointments</h3>
        <?php
        // Retrieve the patient's appointments from the database
        $patientId = $_SESSION['id'];
        $conn = database_connect();
        $query = "SELECT a.*, d.Doctor_Name FROM appointments a INNER JOIN doctors d ON a.Doctor_App_ID = d.Doctor_ID WHERE a.Patient_Appointement_ID = '$patientId'";
        $result = mysqli_query($conn, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            // No appointments to display
            echo '<p>No appointments to display.</p>';
        } else {
            // Display appointments in a table
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Time</th>';
            echo '<th>Doctor</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
				echo '<tr>';
                echo '<td>' . $row['Appointments_Date'] . '</td>';
                echo '<td>' . $row['Appointments_Time'] . '</td>';
                echo '<td>' . $row['Doctor_Name'] . '</td>';
                echo '<td>' . $row['Appointments_status'] . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        }

        mysqli_close($conn);
        ?>
    </div>

</div>
<div class="profile-summary">
    <h2>Profile Summary:</h2>
    <ul>
        <li><strong>Name:</strong> <?php echo $patientName; ?></li>
        <li><strong>Date of Birth:</strong> <?php echo $patientBirthdate; ?></li>
        <li><strong>Medical History:</strong> <?php echo $patientHistory; ?></li>
        <li><strong>Email:</strong> <?php echo $patientEmail; ?></li>
        <li><strong>Gender:</strong> <?php echo $patientGender; ?></li>
        <li><strong>Address:</strong> <?php echo $patientAddress; ?></li>
        <li><strong>Phone:</strong> <?php echo $patientPhone; ?></li>
    </ul>
    <a href="../Edits/edit_patient_profile.php">Edit Profile</a>

    
</div>


</body>


</html>
