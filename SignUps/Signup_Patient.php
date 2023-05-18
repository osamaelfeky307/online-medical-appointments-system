<?php
require_once __DIR__ . "/../Database/database.php";

// Add a new patient to the database
function database_add_patient($name, $email, $password, $birthdate, $gender, $address, $phone, $history)
{
    $conn = database_connect();
    $stmt = mysqli_prepare($conn, 'INSERT INTO patients (Patient_Name, Patient_Email, Patient_Pass, Patient_Birthdate, Patient_Gender, Patient_Address, Patient_Phone, Patient_History)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'ssssssss', $name, $email, $password, $birthdate, $gender, $address, $phone, $history);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["Patient_Name"];
    $email = $_POST["Patient_Email"];
    $password = $_POST["Patient_Pass"];
    $birthdate = $_POST["Patient_Birthdate"];
    $gender = $_POST["Patient_Gender"];
    $address = $_POST["Patient_Address"];
    $phone = $_POST["Patient_Phone"];
    $history = $_POST["Patient_History"];

    // Call the function to add the patient to the database
    database_add_patient($name, $email, $password, $birthdate, $gender, $address, $phone, $history);
    header('location: ../LogIns/Login_Patient.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Patient Signup Page</title>
    <link rel="stylesheet" href="../css/Signup_patient.css">
</head>

<body>
    <h1>Patient Signup</h1>
    <form action="../signups/signup_Patient.php" method="post">
        <label for="Patient_Name">Name:</label>
        <input type="text" id="Patient_Name" name="Patient_Name" required>

        <label for="Patient_Email">Email:</label>
        <input type="email" id="Patient_Email" name="Patient_Email" required>

        <label for="Patient_Pass">Password:</label>
        <input type="password" id="Patient_Pass" name="Patient_Pass" required>

        <label for="Patient_Birthdate">Birth date:</label>
        <input type="date" id="Patient_Birthdate" name="Patient_Birthdate" required>
		<br><br>

        <label>Gender:</label>
		
        <select name="Patient_Gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
		<br><br>

        <label for="Patient_Address">Address:</label>
        <input type="text" id="Patient_Address" name="Patient_Address" required>
		<br>

        <label for="Patient_Phone">Phone number:</label>
        <input type="tel" id="Patient_Phone" name="Patient_Phone" required>
		<br><br>

        <label for="Patient_History">Medical History:</label>
        <textarea id="Patient_History" name="Patient_History" required></textarea>

        <input type="submit" value="Sign Up">
    </form>
</body>

</html>
