<?php
// Example patient records array
$patients = [
    ['id' => 1, 'name' => 'John Doe', 'age' => 35, 'gender' => 'Male'],
    ['id' => 2, 'name' => 'Jane Smith', 'age' => 42, 'gender' => 'Female'],
    ['id' => 3, 'name' => 'Alex Johnson', 'age' => 28, 'gender' => 'Male'],
    // ... Add more patient records here
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patients</title>
    <link rel="stylesheet" type="text/css" href="../css/Patient_Rec.css">
</head>
<body>
    <header>
        <h1>Welcome, [Doctor Name]!</h1>
    </header>

    <nav>
		<ul class="nav-bar">
			<li><a href="../Doc_Dashboard/Upcoming_App.php">Upcoming Appointments</a></li>
			<li><a href="../Doc_Dashboard/Patient_Rec.php">Patient Records</a></li>
			<li><a href="../Doc_Dashboard/Prescription_Mang.php">Prescription Management</a></li>
		</ul>
	</nav>

    <section id="patient-records">
        <h2>Patient Records</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo $patient['id']; ?></td>
                        <td><?php echo $patient['name']; ?></td>
                        <td><?php echo $patient['age']; ?></td>
                        <td><?php echo $patient['gender']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

  
</body>
</html>
