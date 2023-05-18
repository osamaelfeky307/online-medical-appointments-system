<?php
// Include the database connection file
require_once __DIR__ . "/../Database/database.php";

// Check if the prescription ID is set
if (!isset($_GET['prescription-id'])) {
    // Prescription ID is not set, redirect back to the prescription list page
    header("Location: ../Doc_Dashboard/Prescription_Mang.php");
    exit();
} else {
    // Prescription ID is set, retrieve the prescription from the database
    $prescriptionId = $_GET['prescription-id'];
    $conn = database_connect();
    $query = "SELECT * FROM prescription WHERE Prescription_ID = $prescriptionId";
    $result = mysqli_query($conn, $query);

    // Check if the prescription exists
    if (!$result || mysqli_num_rows($result) == 0) {
        // Prescription doesn't exist, redirect back to the prescription list page
        header("Location: ../Prescription_Mang.php");
        exit();
    } else {
        // Prescription exists, retrieve the prescription data
        $row = mysqli_fetch_assoc($result);
        $prescriptionDate = $row['Prescription_Date'];
        $prescriptionMedication = $row['Prescription_Medication'];
        $prescriptionDosage = $row['Prescription_Dosage'];
        $prescriptionInstructions = $row['Prescription_Instructions'];
        $patientId = $row['Patient_ID'];
    }
}

// Check if the update form has been submitted
if (isset($_POST['update-prescription'])) {
    // Get the form data
    $prescriptionDate = $_POST['prescription-date'];
    $prescriptionMedication = $_POST['prescription-medication'];
    $prescriptionDosage = $_POST['prescription-dosage'];
    $prescriptionInstructions = $_POST['prescription-instructions'];

    // Perform database update
    $conn = database_connect();
    $query = "UPDATE prescription SET Prescription_Date = '$prescriptionDate', Prescription_Medication = '$prescriptionMedication', Prescription_Dosage = '$prescriptionDosage', Prescription_Instructions = '$prescriptionInstructions' WHERE Prescription_ID = $prescriptionId";
    mysqli_query($conn, $query);
    mysqli_close($conn);

    // Redirect back to the prescription list page
    header("Location: ../Doc_Dashboard/Prescription_Mang.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Prescription</title>
    <link rel="stylesheet" type="text/css" href="../css/Prescription_Edit.css">
</head>
<body>

<h1>Update Prescription</h1>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?prescription-id=$prescriptionId"; ?>">
    <label for="prescription-date">Date:</label>
    <input type="date" name="prescription-date" id="prescription-date" value="<?php echo $prescriptionDate; ?>" required>
    <label for="prescription-medication">Medication:</label>
    <input type="text" name="prescription-medication" id="prescription-medication" value="<?php echo $prescriptionMedication; ?>" required>
    <label for="prescription-dosage">Dosage:</label>
    <input type="text" name="prescription-dosage" id="prescription-dosage" value="<?php echo $prescriptionDosage; ?>" required>
    <label for="prescription-instructions">Instructions:</label>
    <input type="text" name="prescription-instructions" id="prescription-instructions" value="<?php echo $prescriptionInstructions; ?>" required>
    <input type="submit" name="update-prescription" value="Update Prescription">
</form>

<a href="../Edits/doc_edit_app.php?doctor-id=<?php echo $doctorId; ?>&patient-id=<?php echo $patientId; ?>">Back to Appointments</a>

</body>
</html>