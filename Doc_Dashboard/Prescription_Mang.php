<?php
// Include the database connection file
require_once __DIR__ . "/../Database/database.php";

// Start session
session_start();
// Get the doctor ID from the session
$doctorId = $_SESSION['id'];



// Add Prescription
if (isset($_POST['add-prescription'])) {
    // Get the form data
    $prescriptionDate = $_POST['prescription-date'];
    $prescriptionMedication = $_POST['prescription-medication'];
    $prescriptionDosage = $_POST['prescription-dosage'];
    $prescriptionInstructions = $_POST['prescription-instructions'];
    $patientId = $_POST['patient-id'];
    // Get the doctor ID from the session
    $doctorId = $_SESSION['id'];
    echo "Selected Patient_ID: " . $patientId;

    // Perform database insert
    $conn = database_connect();
    $query = "INSERT INTO prescription (Prescription_Date, Prescription_Medication, Prescription_Dosage, Prescription_Instructions, Prescription_doctor_ID, Patient_ID) VALUES ('$prescriptionDate', '$prescriptionMedication', '$prescriptionDosage', '$prescriptionInstructions', '$doctorId', '$patientId')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}

// Update Prescription
if (isset($_POST['update-prescription'])) {
    // Get the form data
    $prescriptionId = $_POST['prescription-id'];
    $prescriptionDate = $_POST['prescription-date'];
    $prescriptionMedication = $_POST['prescription-medication'];
    $prescriptionDosage = $_POST['prescription-dosage'];
    $prescriptionInstructions = $_POST['prescription-instructions'];
    
    // Perform database update
    $conn = database_connect();
    $query = "UPDATE prescription SET Prescription_Date = '$prescriptionDate', Prescription_Medication = '$prescriptionMedication', Prescription_Dosage = '$prescriptionDosage', Prescription_Instructions = '$prescriptionInstructions' WHERE Prescription_ID = $prescriptionId";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}

// Delete Prescription
if (isset($_GET['delete-prescription'])) {
    // Get the prescription ID to delete
    $prescriptionId = $_GET['delete-prescription'];

    // Perform database delete
    $conn = database_connect();
    $query = "DELETE FROM prescription WHERE Prescription_ID = $prescriptionId";
    mysqli_query($conn, $query);
    mysqli_close($conn);
    $doctorId = $_GET['doctor-id'];

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Clinic Appointments</title>
    <link rel="stylesheet" type="text/css" href="../css/Prescription_Mang.css">
</head>
<body>

<h1>Doctor Dashboard</h1>

<div class="doctor-section">
    
    <div class="add-prescription">
        <h3>Add a Prescription</h3>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="prescription-date">Date:</label>
            <input type="date" name="prescription-date" id="prescription-date" required>
            <label for="prescription-medication">Medication:</label>
            <input type="text" name="prescription-medication" id="prescription-medication" required>
            <label for="prescription-dosage">Dosage:</label>
            <input type="text" name="prescription-dosage" id="prescription-dosage" required>
            <label for="prescription-instructions">Instructions:</label>
        <input type="text" name="prescription-instructions" id="prescription-instructions" required>
        <label for="patient-id">Patient:</label>
        <select name="patient-id" id="patient-id" required>
    <?php
    // Retrieve the list of patients from the database
    $conn = database_connect();
    $query = "SELECT * FROM patients";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['Patient_MRN'] . '">' . $row['Patient_Name'] . ' (ID: ' . $row['Patient_MRN'] . ')</option>';
    }

    mysqli_close($conn);
    ?>
</select>

        <input type="submit" name="add-prescription" value="Add Prescription">
    </form>
</div>

<div class="prescription-list">
    <h3>Prescription List</h3>
    <?php
    // Check if there are any prescriptions in the database
    $conn = database_connect();
    $query = "SELECT p.*, pt.Patient_Name, pt.Patient_MRN
              FROM prescription p 
              INNER JOIN patients pt ON p.Patient_ID = pt.Patient_MRN";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        // No prescriptions to display
        echo '<p>No prescriptions to display.</p>';
    } else {
        // Display prescriptions in a table
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Date</th>';
        echo '<th>Medication</th>';
        echo '<th>Dosage</th>';
        echo '<th>Instructions</th>';
        echo '<th>Patient (ID)</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['Prescription_Date'] . '</td>';
            echo '<td>' . $row['Prescription_Medication'] . '</td>';
            echo '<td>' . $row['Prescription_Dosage'] . '</td>';
            echo '<td>' . $row['Prescription_Instructions'] . '</td>';
            echo '<td>' . $row['Patient_Name'] . ' (' . $row['Patient_MRN'] . ')' . '</td>';
            echo '<td>';
            echo '<a href="../Edits/Prescription_Edit.php?prescription-id=' . $row['Prescription_ID'] . '">Edit</a>';
            echo '<a href="?delete-prescription=' . $row['Prescription_ID'] . '">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    mysqli_close($conn);
    ?>
</div>



<div class="doctor-section">

    <!-- ... (existing code) -->

   <!-- Booked Appointments -->
<div class="appointment-list">
    <h3>Booked Appointments</h3>
    <?php
    // Retrieve the doctor's booked appointments from the database
    $conn = database_connect();
    $query = "SELECT a.*, p.Patient_Name
              FROM appointments a
              INNER JOIN patients p ON a.Patient_Appointement_ID = p.Patient_MRN
              WHERE a.Doctor_App_ID = '$doctorId' AND a.Appointments_status = 'booked'";
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
        echo '<th>Patient</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['Appointments_Date'] . '</td>';
            echo '<td>' . $row['Appointments_Time'] . '</td>';
            echo '<td>' . $row['Patient_Name'] . '</td>';
            echo '<td>';
            echo '<a href="../Edits/doc_edit_app.php?doctor-id=' . $doctorId . '&patient-id=' . $row['Patient_Appointement_ID'] . '">Update</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    mysqli_close($conn);
    ?>
</div>


</div>


</body>
</html>
