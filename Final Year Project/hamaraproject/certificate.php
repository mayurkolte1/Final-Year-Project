<?php
session_start();

/* ✅ Direct DB Connection */
$conn = mysqli_connect("localhost", "root", "", "certificate_db");
if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

require("fpdf/fpdf.php");

/* Logged User */
$username = $_SESSION['username'] ?? "Guest";

/* Form Data */
$name     = $_POST['name'] ?? "Unknown";
$subtitle = $_POST['subtitle'] ?? "Certificate";
$date     = $_POST['date'] ?? date("Y-m-d");
$sign     = $_POST['sign'] ?? "Signature";

/* File Name */
$filename = "certificate_" . time() . ".pdf";

/* Folder */
$folder = "generated_pdfs/";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$file_path = $folder . $filename;

/* Generate PDF */
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 20);
$pdf->Cell(190, 20, "CERTIFICATE", 0, 1, "C");

$pdf->SetFont("Arial", "", 14);
$pdf->Cell(190, 10, $subtitle, 0, 1, "C");

$pdf->Ln(10);
$pdf->SetFont("Arial", "B", 18);
$pdf->Cell(190, 10, $name, 0, 1, "C");

/* Save PDF */
$pdf->Output("F", $file_path);

/* Log Info */
$info = "Certificate Generated for: $name";

/* Insert Log */
$stmt = $conn->prepare("INSERT INTO pdf_logs (username, pdf_file) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $info);

if(!$stmt->execute()){
    die("Insert Failed: " . $stmt->error);
}

/* Force Download */
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=$filename");
readfile($file_path);
exit();
?>
