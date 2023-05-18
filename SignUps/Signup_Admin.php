<?php
require_once __DIR__ . "/../Database/database.php";


// Add a new admin to the database
function database_add_admin($name, $email, $password, $gender, $birth_date, $address, $phone)
{
    $conn = database_connect();
    $stmt = mysqli_prepare($conn, 'INSERT INTO admins (Admin_Name, Admin_Email, Admin_Password, Admin_Gender, Admin_Birthdate, Admin_Address, Admin_Phone)
        VALUES (?, ?, ?, ?, ?, ?, ?)');
    // Hash the password before storing it in the database
   // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, 'ssssdss', $name, $email, $password, $gender, $birth_date, $address, $phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["Admin_Name"];
    $email = $_POST["Admin_Email"];
    $password = $_POST["Admin_Password"];
    $gender = $_POST["Admin_Gender"];
    $birth_date = $_POST["Admin_Birthdate"];
    $address = $_POST["Admin_Address"];
    $phone = $_POST["Admin_Phone"];

    // Call the function to add the admin to the database
    database_add_admin($name, $email, $password, $gender, $birth_date, $address, $phone);
    header('location: ../LogIns/Login_Admin.php');
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Signup Page</title>
    <link rel="stylesheet" href="../css/Signup_admin.css">
</head>

<body>
    <h1>Admin Signup</h1>
    <form action="../signups/signup_Admin.php" method="post">
        <label for="Admin_Name">Name:</label>
        <input type="text" id="Admin_Name" name="Admin_Name" required>

        <label for="Admin_Email">Email:</label>
        <input type="email" id="Admin_Email" name="Admin_Email" required>

        <label for="Admin_Password">Password:</label>
        <input type="password" id="Admin_Password" name="Admin_Password" required>

        <label>Gender:</label>
        <select name="Admin_Gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <br>
        <br>
        <label for="Admin_Birthdate">Birth date:</label>
        <input type="date" id="Admin_Birthdate" name="Admin_Birthdate" required>
        <br>
        <br>
        <label for="Admin_Address">Address:</label>
        <input type="text" id="Admin_Address" name="Admin_Address" required>

        <label for="Admin_Phone">Phone number:</label>
        <input type="tel" id="Admin_Phone" name="Admin_Phone" required>

        <input type="submit" value="Sign Up">
    </form>
</body>

</html> <!-- Add the missing > character here -->```