<?php
session_start();
include('../config/connection.php');
if (!isset($_SESSION['user']) || $_SESSION['usertype'] != 'a') {
    header('location: ../login.php');
    exit();
}

$doc_count = $database->query("SELECT * FROM doctor")->num_rows;
$pat_count = $database->query("SELECT * FROM patient")->num_rows;
$app_count = $database->query("SELECT * FROM appointment")->num_rows;
$sch_count = $database->query("SELECT * FROM schedule WHERE scheduledate=CURDATE()")->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="layout-container">
    <div class="sidebar">
        <div class="user-info">
            <h3>Administrator</h3>
            <p>admin@edoc.com</p>
            <a href="../logout.php" class="btn btn-secondary" style="margin-top:10px;">Log out</a>
        </div>
        <ul>
            <li><a href="index.php" class="active">Dashboard</a></li>
            <li><a href="doctors.php">Doctors</a></li>
            <li><a href="schedule.php">Schedule</a></li>
            <li><a href="appointment.php">Appointment</a></li>
            <li><a href="patients.php">Patients</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <h2>Status</h2>
            <span>Today's Date: <?php echo date('Y-m-d'); ?></span>
        </div>
        <div class="status-cards">
            <div class="card"><h2><?php echo $doc_count; ?></h2><p>Doctors</p></div>
            <div class="card"><h2><?php echo $pat_count; ?></h2><p>Patients</p></div>
            <div class="card"><h2><?php echo $app_count; ?></h2><p>NewBooking</p></div>
            <div class="card"><h2><?php echo $sch_count; ?></h2><p>Today Sessions</p></div>
        </div>

        <h3>Upcoming Sessions until Next Tuesday</h3>
        <table class="data-table" style="margin-top:15px;">
            <thead>
                <tr>
                    <th>Session Title</th>
                    <th>Doctor</th>
                    <th>Scheduled Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $schedules = $database->query("SELECT s.title, d.docname, s.scheduledate, s.scheduletime FROM schedule s JOIN doctor d ON s.docid=d.docid LIMIT 5");
                while($row = $schedules->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['docname']}</td>
                        <td>{$row['scheduledate']} {$row['scheduletime']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>