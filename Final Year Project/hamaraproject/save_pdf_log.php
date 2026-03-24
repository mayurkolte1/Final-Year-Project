<?php
session_start();

/* ✅ Direct DB Connection */
$conn = mysqli_connect("localhost", "root", "", "certificate_db");

if (!$conn) {
    die("Database Connection Failed");
}

$username = $_POST['username'] ?? "Guest";
$pdf_file = $_POST['pdf_file'] ?? "Certificate.pdf";

/* Insert Log */
$sql = "INSERT INTO pdf_logs(username, pdf_file)
        VALUES('$username','$pdf_file')";

mysqli_query($conn, $sql);

echo "Saved";
?>
