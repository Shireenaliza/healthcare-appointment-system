<?php
session_start();
include('config/connection.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $nic = $_POST['nic'];
    $dob = $_POST['dob'];
    $tel = $_POST['tel'];

    $check = $database->query("SELECT * FROM webuser WHERE email='$email'");
    if ($check->num_rows > 0) {
        $error = "Email already exists!";
    } else {
        $database->query("INSERT INTO patient (pemail, pname, ppassword, paddress, pnic, pdob, ptel) VALUES ('$email', '$name', '$password', '$address', '$nic', '$dob', '$tel')");
        $database->query("INSERT INTO webuser (email, usertype) VALUES ('$email', 'p')");
        $_SESSION['user'] = $email;
        $_SESSION['usertype'] = 'p';
        header('location: patient/index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - eDoc</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh;">
    <div class="card" style="width: 400px;">
        <h2>Create Account</h2>
        <p style="margin-bottom:15px;">Enter your details to sign up as a patient</p>
        <?php if($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
        <form action="" method="POST">
            <div class="form-group"><label>Full Name:</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Email:</label><input type="email" name="email" required></div>
            <div class="form-group"><label>NIC:</label><input type="text" name="nic" required></div>
            <div class="form-group"><label>Telephone:</label><input type="text" name="tel" required></div>
            <div class="form-group"><label>Address:</label><input type="text" name="address" required></div>
            <div class="form-group"><label>Date of Birth:</label><input type="date" name="dob" required></div>
            <div class="form-group"><label>Password:</label><input type="password" name="password" required></div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Sign Up</button>
        </form>
        <p style="margin-top:15px; text-align:center;">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>