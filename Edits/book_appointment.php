<?php
// book_appointment.php

session_start();

require_once __DIR__ . "/../Database/database.php";

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: ../LogIns/Login_Patient.php');
    exit();
}

// Get the patient ID from the session
$patientID = $_SESSION['id'];

// Get the selected doctor, date, and time from the form submission
$doctor = $_POST['doctor'];
$date = $_POST['date'];
$time = $_POST['time'];

// Validate and sanitize the input here...

// Establish the database connection
$con = database_connect();

// Check if the appointment already exists for the patient
$existingStmt = $con->prepare('SELECT COUNT(*) FROM Appointments WHERE Appointments_Date = ? AND Appointments_Time = ? AND Patient_Appointement_ID = ?');
$existingStmt->bind_param('ssi', $date, $time, $patientID);
$existingStmt->execute();
$existingStmt->bind_result($existingCount);
$existingStmt->fetch();
$existingStmt->close();

if ($existingCount > 0) {
    // Appointment already exists, handle the error
    $_SESSION['error'] = 'This appointment is already booked this appointment.';
    header('Location: ../HomePages/HP_Patient.php');
    exit();
}

// Insert the new appointment into the database
$insertStmt = $con->prepare('INSERT INTO Appointments (Appointments_Date, Appointments_Time, Appointments_status, Patient_Appointement_ID) VALUES (?, ?, ?, ?)');
$status = "Booked";
$insertStmt->bind_param('sssi', $date, $time, $status, $patientID);
$insertStmt->execute();
$insertStmt->close();

// Redirect the user to the home page or a confirmation page
header('Location: ../HomePages/HP_Patient.php');
exit();
?>

