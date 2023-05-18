<?php
// Sample data for demonstration
$upcomingAppointments = [
    [
        'patientName' => 'John Doe',
        'appointmentDate' => '2023-05-15',
        'appointmentTime' => '10:00 AM',
    ],
    [
        'patientName' => 'Jane Smith',
        'appointmentDate' => '2023-05-16',
        'appointmentTime' => '2:30 PM',
    ],
    // Add more sample appointment data here
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/Upcoming_App.css">
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

    <section id="upcoming-appointments">
        <h2>Upcoming Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($upcomingAppointments as $appointment): ?>
                    <tr>
                        <td><?php echo $appointment['patientName']; ?></td>
                        <td><?php echo $appointment['appointmentDate']; ?></td>
                        <td><?php echo $appointment['appointmentTime']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

   
</body>
</html>
