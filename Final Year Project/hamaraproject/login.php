<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ✅ Database Connection */
$conn = new mysqli("localhost", "root", "", "certificate_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/* ✅ Only POST Request Allowed */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: main.html");
    exit();
}

/* ✅ Form Inputs */
$username = trim($_POST['username']);
$password = trim($_POST['password']);

/* ✅ Check User Exists */
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $row = $result->fetch_assoc();

    /* ✅ Password Verify */
    if (password_verify($password, $row['password'])) {

        /* ✅ SESSION SET */
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        /* ✅ Insert Login Log */
        $uid = $row['id'];
        $uname = $row['username'];

        $log = $conn->prepare(
            "INSERT INTO login_logs (user_id, username, login_time) VALUES (?, ?, NOW())"
        );
        $log->bind_param("is", $uid, $uname);
        $log->execute();

        /* ✅ Redirect Dashboard */
        header("Location: dashboard.php");
        exit();

    } else {
        echo "<script>alert('❌ Invalid Password'); history.back();</script>";
    }

} else {
    echo "<script>alert('❌ Username not found'); history.back();</script>";
}

$conn->close();
?>
