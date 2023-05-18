<?php
require_once __DIR__ . '/../Database/database.php';

// Add a new doctor to the database
function database_add_doctor($name, $email, $password, $gender, $birthdate, $address, $phone, $specialization)
{
    $conn = database_connect();
    $stmt = mysqli_prepare($conn, 'INSERT INTO Doctors (Doctor_Name, Doctor_Email, Doctor_Password, Doctor_Gender, Doctor_Birthdate, Doctor_Address, Doctor_Phone, Doctor_Specialization)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    // Hash the password before storing it in the database
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, 'ssssdsss', $name, $email, $password, $gender, $birthdate, $address, $phone, $specialization);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];

    // Call the function to add the doctor to the database
    database_add_doctor($name, $email, $password, $gender, $birthdate, $address, $phone, $specialization);
    header('Location: ../LogIns/Login_Doc.php');
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Doctor Signup Page</title>
	<link rel="stylesheet" type="text/css" href="../css/Signup_doc.css">
</head>
<body>
	<h1>Doctor Signup</h1>
	<form action="../SignUps/Signup_Doc.php" method="post">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required>

		<label>Gender:</label>
		<select name="gender" required>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
		</select>

		<br>
		<br>
		<label for="birthdate">Birth date:</label>
		<input type="date" id="birthdate" name="birthdate" required>
		<br>
		<br>
		<label for="address">Address:</label>
		<input type="text" id="address" name="address" required>

		<label for="phone">Phone number:</label>
		<input type="tel" id="phone" name="phone" required>

		<label for="specialization">Specialization:</label>
		<input type="text" id="specialization" name="specialization" required>

		<input type="submit" value="Sign Up">
	</form>
</body>
</html>