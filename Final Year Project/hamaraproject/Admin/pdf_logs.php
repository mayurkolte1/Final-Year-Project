<?php
session_start();

/* ✅ Admin Login Check */
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}

/* ✅ Database Connection */
$conn = mysqli_connect("localhost", "root", "", "certificate_db");

if (!$conn) {
    die("Database Connection Failed");
}

/* ✅ Fetch Logs */
$result = mysqli_query($conn, "SELECT * FROM pdf_logs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Downloaded Certificate Logs</title>

    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            padding:20px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
            font-size:24px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            box-shadow:0px 0px 10px gray;
            border-radius:10px;
            overflow:hidden;
        }

        th,td{
            padding:12px;
            border:1px solid #ddd;
            text-align:center;
        }

        th{
            background:#007bff;
            color:white;
            font-size:16px;
        }

        tr:hover{
            background:#f1f1f1;
        }

        a{
            text-decoration:none;
            color:blue;
            font-weight:bold;
        }

        a:hover{
            color:darkred;
        }
    </style>
</head>

<body>

<h2>📄 Downloaded Certificates Logs</h2>

<table>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>PDF File</th>
    <th>Date & Time</th>
</tr>

<?php
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['username']."</td>";

        /* ✅ PDF Clickable Link */
      echo "<td>".$row['pdf_file']."</td>";



        echo "<td>".$row['created_at']."</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='4'>No Downloads Yet</td></tr>";
}
?>

</table>

</body>
</html>
