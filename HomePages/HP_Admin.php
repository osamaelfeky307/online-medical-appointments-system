<?php
// Include the database connection file
require_once __DIR__ . "/../Database/database.php";

// Add Doctor
if (isset($_POST['add-doctor'])) {
    // Get the form data
    $docName = $_POST['doc-name'];
    $docEmail = $_POST['doc-email'];
    $docPassword = $_POST['doc-password'];
    $docBirthdate = $_POST['doc-birthdate'];
    $docAddress = $_POST['doc-address'];
    $docPhone = $_POST['doc-phone'];
    $docSpecialization = $_POST['doc-specialization'];
    
    // Get the admin ID from the session
    session_start();
    $adminId = $_SESSION['id'];
    session_write_close();

    // Perform database insert
    $conn = database_connect();
    $query = "INSERT INTO doctors (Doctor_Name, Doctor_Email, Doctor_Password, Doctor_Birthdate, Doctor_Address, Doctor_Phone, Doctor_Specialization, Adminstration_Doc_ID) VALUES ('$docName', '$docEmail', '$docPassword', '$docBirthdate', '$docAddress', '$docPhone', '$docSpecialization', '$adminId')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}


// Delete Doctor
if (isset($_GET['delete-doctor'])) {
    // Get the doctor ID to delete
    $doctorId = $_GET['delete-doctor'];

    // Perform database delete
    $conn = database_connect();
    $query = "DELETE FROM doctors WHERE Doctor_ID = $doctorId";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}

// Add Patient
if (isset($_POST['add-patient'])) {
    // Get the form data
    $patName = $_POST['pat-name'];
    $patEmail = $_POST['pat-email'];
    $patPass = $_POST['pat-pass'];
    $patBirthdate = $_POST['pat-birthdate'];
    $patGender = $_POST['pat-gender'];
    $patAddress = $_POST['pat-address'];
    $patPhone = $_POST['pat-phone'];
    $patHistory = $_POST['pat-history'];

    // Perform database insert
    $conn = database_connect();
    $query = "INSERT INTO patients (Patient_Name, Patient_Email, Patient_Pass, Patient_Birthdate, Patient_Gender, Patient_Address, Patient_Phone, Patient_History) VALUES ('$patName', '$patEmail', '$patPass', '$patBirthdate', '$patGender', '$patAddress', '$patPhone', '$patHistory')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Clinic Appointments</title>
    <link rel="stylesheet" type="text/css" href="../css/HP_Admin.css">
</head>
<body>
    <h1>Medical center</h1>

    <h2>Doctors</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Birthdate</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Specialization</th>
            <th>Action</th>
        </tr>
        <?php
        // Fetch all doctors from the database
        $conn = database_connect();
        $query = "SELECT * FROM doctors";
        $result = mysqli_query($conn, $query);

        // Loop through the result set and display the data in a table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Doctor_ID'] . "</td>";
            echo "<td>" . $row['Doctor_Name'] . "</td>";
            echo "<td>" . $row['Doctor_Email'] . "</td>";
            echo "<td>" . $row['Doctor_Birthdate'] . "</td>";
            echo "<td>" . $row['Doctor_Address'] . "</td>";
            echo "<td>" . $row['Doctor_Phone'] . "</td>";
            echo "<td>" . $row['Doctor_Specialization'] . "</td>";
            echo "<td><a href='../Edits/Doctor_Edit.php?doctor-id=" . $row['Doctor_ID'] . "'>Edit</a> | <a href='?delete-doctor=" . $row['Doctor_ID'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        // Release the resources associated with the result set
        mysqli_free_result($result);

        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>

    <h3>Add Doctor</h3>
    <form method="post">
        <label>Name</label>
        <input type="text" name="doc-name" required>

        <label>Email</label>
        <input type="email" name="doc-email" required>

        <label>Password</label>
        <input type="password" name="doc-password" required>

        <label>Birthdate</label>
        <input type="date" name="doc-birthdate" required>

        <label>Address</label>
        <input type="text" name="doc-address" required>

        <label>Phone</label>
        <input type="text" name="doc-phone" required>

        <label>Specialization</label>
        <input type="text" name="doc-specialization" required>

        <input type="submit" name="add-doctor" value="Add Doctor">
    </form>

    <h2>Patients</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Birthdate</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Medical History</th>
        </tr>
        <?php
        // Fetch all patients from the database
        $conn = database_connect();
        $query = "SELECT * FROM patients";
        $result = mysqli_query($conn, $query);

        // Loop through the result set and display the data in a table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Patient_MRN'] . "</td>";
            echo "<td>" . $row['Patient_Name'] . "</td>";
            echo "<td>" . $row['Patient_Email'] . "</td>";
            echo "<td>" . $row['Patient_Birthdate'] . "</td>";
            echo "<td>" . $row['Patient_Gender'] . "</td>";
            echo "<td>" . $row['Patient_Address'] . "</td>";
            echo "<td>" . $row['Patient_Phone'] . "</td>";
            echo "<td>" . $row['Patient_History'] . "</td>";
            echo "</tr>";
        }

        // Release the resources associated with the result set
        mysqli_free_result($result);

        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>

    <h3>Add Patient</h3>
    <form method="post">
        <label>Name</label>
        <input type="text" name="pat-name" required>

        <label>Email</label>
        <input type="email" name="pat-email" required>

        <label>Password</label>
        <input type="password" name="pat-pass" required>

        <label>Birthdate</label>
        <input type="date" name="pat-birthdate" required>

        <label>Gender</label>
        <select name="pat-gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label>Address</label>
        <input type="text" name="pat-address" required>

        <label>Phone</label>
        <input type="text" name="pat-phone" required>

        <label>Medical History</label>
        <textarea name="pat-history" required></textarea>

        <input type="submit" name="add-patient" value="Add Patient">
    </form>
</body>
</html>