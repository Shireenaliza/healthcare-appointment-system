<?php
session_start();
include('../config/connection.php');
if (!isset($_SESSION['user']) || $_SESSION['usertype'] != 'a') {
    header('location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patients List</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="layout-container">
    <div class="sidebar">
        <h3>Administrator</h3>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="doctors.php">Doctors</a></li>
            <li><a href="schedule.php">Schedule</a></li>
            <li><a href="appointment.php">Appointment</a></li>
            <li><a href="patients.php" class="active">Patients</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2>All Patients</h2>
        <table class="data-table" style="margin-top:20px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>NIC</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Events</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $database->query("SELECT * FROM patient");
                while($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['pname']}</td>
                        <td>{$row['pnic']}</td>
                        <td>{$row['ptel']}</td>
                        <td>{$row['pemail']}</td>
                        <td>{$row['pdob']}</td>
                        <td><a href='?action=view&id={$row['pid']}' class='btn btn-secondary'>View</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if(isset($_GET['action']) && $_GET['action']=='view'): 
            $id = $_GET['id'];
            $p = $database->query("SELECT * FROM patient WHERE pid='$id'")->fetch_assoc();
        ?>
        <div class="modal">
            <div class="modal-content">
                <h3>View Details</h3>
                <p><b>Patient ID:</b> P-<?php echo $p['pid']; ?></p>
                <p><b>Name:</b> <?php echo $p['pname']; ?></p>
                <p><b>Email:</b> <?php echo $p['pemail']; ?></p>
                <p><b>NIC:</b> <?php echo $p['pnic']; ?></p>
                <p><b>Telephone:</b> <?php echo $p['ptel']; ?></p>
                <p><b>Address:</b> <?php echo $p['paddress']; ?></p>
                <p><b>Date of Birth:</b> <?php echo $p['pdob']; ?></p>
                <a href="patients.php" class="btn btn-primary" style="margin-top:15px; display:inline-block;">OK</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>