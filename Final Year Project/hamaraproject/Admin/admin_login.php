<?php
session_start();

/* ✅ Database Connection */
$conn = new mysqli("localhost", "root", "", "certificate_db");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

/* ✅ Form Data */
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

/* ✅ Empty Check */
if ($username == "" || $password == "") {
    echo "<script>alert('Please enter Username and Password');history.back();</script>";
    exit();
}

/* ✅ Fetch Admin Password Hash */
$stmt = $conn->prepare("SELECT username, password FROM admin WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

/* ✅ Admin Found */
if ($res->num_rows === 1) {

    $row = $res->fetch_assoc();

    /* ✅ Password Verify */
    if (password_verify($password, $row['password'])) {

        /* ✅ Session Set Properly */
        $_SESSION['admin'] = $row['username'];

        /* ✅ Redirect Dashboard */
        header("Location: admin_dashboard.php");
        exit();

    } else {
        echo "<script>alert('Invalid Password');history.back();</script>";
        exit();
    }

} else {

    echo "<script>alert('Admin not found');history.back();</script>";
    exit();
}
?>
