<?php
// Include the database connection file
require_once __DIR__ . "/../Database/database.php";


$doctorId = $_GET['doctor-id'];

// Check if the doctor ID is provided in the URL
if (!isset($_GET['doctor-id'])) {
    // No doctor ID provided
    header("Location: error.php");
    exit;
}


// Fetch the doctor details from the database
$conn = database_connect();
$query = "SELECT * FROM doctors WHERE Doctor_ID = $doctorId";
$result = mysqli_query($conn, $query);
$doctor = mysqli_fetch_assoc($result);
mysqli_close($conn);

if (!$doctor) {
    // Doctor not found
    header("Location: error.php");
    exit;
}

// Handle form submission
if (isset($_POST['update-doctor'])) {
    // Get the form data
    $docName = $_POST['doc-name'];
    $docEmail = $_POST['doc-email'];
    $docPassword = $_POST['doc-password'];
    $docBirthdate = $_POST['doc-birthdate'];
    $docAddress = $_POST['doc-address'];
    $docPhone = $_POST['doc-phone'];
    $docSpecialization = $_POST['doc-specialization'];

    // Perform database update
    $conn = database_connect();
    $query = "UPDATE doctors SET Doctor_Name = '$docName', Doctor_Email = '$docEmail', Doctor_Password = '$docPassword', Doctor_Birthdate = '$docBirthdate', Doctor_Address = '$docAddress', Doctor_Phone = '$docPhone', Doctor_Specialization = '$docSpecialization' WHERE Doctor_ID = $doctorId";
    mysqli_query($conn, $query);
    mysqli_close($conn);

    // Redirect back to the main page after updating the doctor
    header("Location: ../HomePages/HP_Admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
    <link rel="stylesheet" type="text/css" href="../css/HP_Admin.css">
</head>
<body>
    <h1>Edit Doctor</h1>

    <div class="edit-doctor">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?doctor-id=$doctorId"; ?>">
            <label for="doc-name">Name:</label>
            <input type="text" name="doc-name" id="doc-name" value="<?php echo $doctor['Doctor_Name']; ?>" required>
            <label for="doc-email">Email:</label>
            <input type="email" name="doc-email" id="doc-email" value="<?php echo $doctor['Doctor_Email']; ?>" required>
            <label for="doc-password">Password:</label>
            <input type="password" name="doc-password" id="doc-password" value="<?php echo $doctor['Doctor_Password']; ?>" required>
            <label for="doc-birthdate">Birthdate:</label>
            <input type="text" name="doc-birthdate" id="doc-birthdate" value="<?php echo $doctor['Doctor_Birthdate']; ?>" required>
            <label for="doc-address">Address:</label>
            <input type="text" name="doc-address" id="doc-address" value="<?php echo $doctor['Doctor_Address']; ?>" required>
            <label for="doc-phone">Phone:</label>
            <input type="text" name="doc-phone" id="doc-phone" value="<?php echo $doctor['Doctor_Phone']; ?>" required>
            <label for="doc-specialization">Specialization:</label>
            <input type="text" name="doc-specialization" id="doc-specialization" value="<?php echo $doctor['Doctor_Specialization']; ?>" required>
            <input type="submit" name="update-doctor" value="Update Doctor">
        </form>
    </div>

</body>
</html>