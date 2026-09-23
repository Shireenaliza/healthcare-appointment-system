<?php
session_start();
include('../config/connection.php');
if (!isset($_SESSION['user']) || $_SESSION['usertype'] != 'a') {
    header('location: ../login.php');
    exit();
}

if (isset($_POST['add_session'])) {
    $docid = $_POST['docid'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $nop = $_POST['nop'];

    $database->query("INSERT INTO schedule (docid, title, scheduledate, scheduletime, nop) VALUES ('$docid', '$title', '$date', '$time', '$nop')");
    header('location: schedule.php');
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $database->query("DELETE FROM schedule WHERE scheduleid='$id'");
    header('location: schedule.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Manager</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="layout-container">
    <div class="sidebar">
        <div class="user-info">
            <h3>Administrator</h3>
            <p>admin@edoc.com</p>
        </div>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="doctors.php">Doctors</a></li>
            <li><a href="schedule.php" class="active">Schedule</a></li>
            <li><a href="appointment.php">Appointment</a></li>
            <li><a href="patients.php">Patients</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <h2>Schedule Manager</h2>
            <a href="schedule.php?action=add" class="btn btn-primary">+ Add Session</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Session Title</th>
                    <th>Doctor</th>
                    <th>Scheduled Date & Time</th>
                    <th>Max Bookings</th>
                    <th>Events</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $database->query("SELECT s.*, d.docname FROM schedule s JOIN doctor d ON s.docid=d.docid");
                while($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['docname']}</td>
                        <td>{$row['scheduledate']} {$row['scheduletime']}</td>
                        <td>{$row['nop']}</td>
                        <td><a href='?action=delete&id={$row['scheduleid']}' class='btn btn-danger'>Remove</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if(isset($_GET['action']) && $_GET['action']=='add'): ?>
        <div class="modal">
            <div class="modal-content">
                <h3>Schedule a Session</h3>
                <form method="POST" action="schedule.php">
                    <div class="form-group"><label>Session Title:</label><input type="text" name="title" required></div>
                    <div class="form-group">
                        <label>Doctor:</label>
                        <select name="docid">
                            <?php 
                            $docs = $database->query("SELECT * FROM doctor");
                            while($d = $docs->fetch_assoc()) echo "<option value='{$d['docid']}'>{$d['docname']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Date:</label><input type="date" name="date" required></div>
                    <div class="form-group"><label>Time:</label><input type="time" name="time" required></div>
                    <div class="form-group"><label>Max Patients (NOP):</label><input type="number" name="nop" required></div>
                    <button type="submit" name="add_session" class="btn btn-primary">Save Session</button>
                    <a href="schedule.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>