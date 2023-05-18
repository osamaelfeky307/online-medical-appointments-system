<?php
// Include the database connection file
require_once __DIR__ . "/../Database/database.php";

// Start session
session_start();
// Get the doctor ID from the session
$doctorId = $_SESSION['id'];

// Check if the prescription ID is provided in the URL
if (isset($_GET['prescription-id'])) {
    $prescriptionId = $_GET['prescription-id'];

    // Retrieve the prescription details from the database
    $conn = database_connect();
    $query = "SELECT * FROM prescription WHERE Prescription_ID = $prescriptionId";
    $result = mysqli_query($conn, $query);
    $prescription = mysqli_fetch_assoc($result);
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

    // Redirect to the prescription list page
    header("Location: ../Doc_Dashboard/Prescription_Mang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Prescription</title>
    <link rel="stylesheet" type="text/css" href="../css/Prescription_Edit.css">
</head>
<body>
    <h1>Edit Prescription</h1>

    <div class="edit-prescription">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="prescription-id" value="<?php echo $prescription['Prescription_ID']; ?>">
            
            <label for="prescription-date">Date:</label>
            <input type="date" name="prescription-date" id="prescription-date" value="<?php echo $prescription['Prescription_Date']; ?>" required>
            
            <label for="prescription-medication">Medication:</label>
            <input type="text" name="prescription-medication" id="prescription-medication" value="<?php echo $prescription['Prescription_Medication']; ?>" required>
            
            <label for="prescription-dosage">Dosage:</label>
            <input type="text" name="prescription-dosage" id="prescription-dosage" value="<?php echo $prescription['Prescription_Dosage']; ?>" required>
            
            <label for="prescription-instructions">Instructions:</label>
            <input type="text" name="prescription-instructions" id="prescription-instructions" value="<?php echo $prescription['Prescription_Instructions']; ?>" required>

            <input type="submit" name="update-prescription" value="Update Prescription">
        </form>
    </div>

</body>
</html>
