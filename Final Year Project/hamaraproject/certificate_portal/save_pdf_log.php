<?php
session_start();
include("db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$username = $_POST['username'] ?? "Guest";
$pdf_file = $_POST['pdf_file'] ?? "Certificate.pdf";

/* Insert Log */
$sql = "INSERT INTO pdf_logs (username, pdf_file)
        VALUES ('$username', '$pdf_file')";

if(mysqli_query($conn, $sql)){
    echo "Log Saved Successfully ✅";
}else{
    echo "DB Error: " . mysqli_error($conn);
}
?>
