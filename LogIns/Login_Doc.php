<?php

require_once __DIR__ . "/../Database/database.php";

// Establish the database connection
$con = database_connect();

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT Doctor_ID, Doctor_Password FROM doctors WHERE Doctor_Email = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($Doctor_ID, $Doctor_Password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        if ($_POST['password'] === $Doctor_Password) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $Doctor_ID;
            
            header('Location: ../HomePages/HP_Doc.php');
            exit();
        } else {
            // Incorrect password
            echo 'Incorrect email and/or password!';
        }
    } 

    $stmt->close();
}

// Close the database connection
$con->close();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="../css/Login_Doc.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
        <div class="login">
            <h1>Login</h1>
            <form action="../LogIns/Login_Doc.php" method="post">
                <label for="username">
                    <i class="fas fa-envelope"></i>
                </label>
                <input type="email" name="username" placeholder="Email" id="username" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <input type="submit" value="Login">
            </form>
        </div>
    </body>
</html>