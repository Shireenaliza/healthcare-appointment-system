<?php
session_start();
include('../config/connection.php');

if (isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $nic = $_POST['nic'];
    $tele = $_POST['tele'];
    $spec = $_POST['spec'];
    $password = $_POST['password'];

    $database->query("INSERT INTO doctor (docemail, docname, docpassword, docnic, doctel, specialties) VALUES ('$email', '$name', '$password', '$nic', '$tele', '$spec')");
    $database->query("INSERT INTO webuser (email, usertype) VALUES ('$email', 'd')");
    header('location: doctors.php?action=added');
}

if (isset($_GET['action']) && $_GET['action']=='delete') {
    $id = $_GET['id'];
    $database->query("DELETE FROM doctor WHERE docid='$id'");
    header('location: doctors.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="layout-container">
    <div class="sidebar">
        <h3>Administrator</h3>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="doctors.php" class="active">Doctors</a></li>
            <li><a href="schedule.php">Schedule</a></li>
            <li><a href="appointment.php">Appointment</a></li>
            <li><a href="patients.php">Patients</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <h2>All Doctors</h2>
            <a href="doctors.php?action=add" class="btn btn-primary">+ Add New</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Email</th>
                    <th>Specialties</th>
                    <th>Events</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $database->query("SELECT d.*, s.sname FROM doctor d LEFT JOIN specialties s ON d.specialties=s.id");
                while($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['docname']}</td>
                        <td>{$row['docemail']}</td>
                        <td>{$row['sname']}</td>
                        <td>
                            <a href='?action=view&id={$row['docid']}' class='btn btn-secondary'>View</a>
                            <a href='?action=delete&id={$row['docid']}' class='btn btn-danger'>Remove</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add Doctor Modal -->
        <?php if(isset($_GET['action']) && $_GET['action']=='add'): ?>
        <div class="modal">
            <div class="modal-content">
                <h3>Add New Doctor</h3>
                <form method="POST" action="doctors.php">
                    <div class="form-group"><label>Name:</label><input type="text" name="name" required></div>
                    <div class="form-group"><label>Email:</label><input type="email" name="email" required></div>
                    <div class="form-group"><label>NIC:</label><input type="text" name="nic" required></div>
                    <div class="form-group"><label>Telephone:</label><input type="text" name="tele" required></div>
                    <div class="form-group">
                        <label>Choose specialties:</label>
                        <select name="spec">
                            <?php 
                            $specs = $database->query("SELECT * FROM specialties");
                            while($s = $specs->fetch_assoc()) echo "<option value='{$s['id']}'>{$s['sname']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Password:</label><input type="password" name="password" required></div>
                    <button type="submit" name="add_doctor" class="btn btn-primary">Save</button>
                    <a href="doctors.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>