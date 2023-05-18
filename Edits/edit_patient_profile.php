<?php
session_start();

require_once __DIR__ . "/../Database/database.php";

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: ../LogIns/Login_Patient.php');
    exit();
}

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

// Check if the form is submitted for updating the patient's information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $newName = $_POST['name'];
    $newBirthdate = $_POST['birthdate'];
    $newHistory = $_POST['history'];
    $newEmail = $_POST['email'];
    $newGender = $_POST['gender'];
    $newAddress = $_POST['address'];
    $newPhone = $_POST['phone'];

    // Update the patient's information in the database
    $updateStmt = $con->prepare('UPDATE Patients SET Patient_Name = ?, Patient_Birthdate = ?, Patient_History = ?, Patient_Email = ?, Patient_Gender = ?, Patient_Address = ?, Patient_Phone = ? WHERE Patient_MRN = ?');
    $updateStmt->bind_param('sssssssi', $newName, $newBirthdate, $newHistory, $newEmail, $newGender, $newAddress, $newPhone, $patientID);
    $updateStmt->execute();
    $updateStmt->close();

    // Redirect back to the home page
    header('Location: ../HomePages/HP_Patient.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/edit_patient_profile.css">
</head>
<body>
    <h1>Edit Profile</h1>
    <
    <form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($patientName); ?>" required>

    <label for="birthdate">Date of Birth:</label>
    <input type="date" name="birthdate" value="<?php echo htmlspecialchars($patientBirthdate); ?>" required>

    <label for="history">Medical History:</label>
    <textarea name="history" required><?php echo htmlspecialchars($patientHistory); ?></textarea>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($patientEmail); ?>" required>

    <label for="gender">Gender:</label>
    <input type="text" name="gender" value="<?php echo htmlspecialchars($patientGender); ?>" required>

    <label for="address">Address:</label>
    <input type="text" name="address" value="<?php echo htmlspecialchars($patientAddress); ?>" required>

    <label for="phone">Phone:</label>
    <input type="tel" name="phone" value="<?php echo htmlspecialchars($patientPhone); ?>" required>

    <input type="submit" name="submit" value="Update Profile">
</form>
