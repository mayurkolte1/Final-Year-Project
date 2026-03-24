<?php
$conn = new mysqli("localhost","root","","certificate_db");

if($conn->connect_error){
    die("Connection failed");
}

$result = $conn->query("SELECT * FROM help_requests ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Help Requests</title>
<style>
body{
    font-family: Arial;
    background:#f4f4f4;
    padding:20px;
}

table{
    width:100%;
    border-collapse: collapse;
    background:white;
}

th,td{
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}

th{
    background:#764ba2;
    color:white;
}

img{
    width:100px;
}
</style>
</head>
<body>

<h2>Help Requests</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Problem</th>
<th>Screenshot</th>
<th>Date</th>
</tr>

<?php while($row=$result->fetch_assoc()) { ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['problem']; ?></td>
<td><img src="../<?php echo $row['screenshot']; ?>"></td>
<td><?php echo $row['submitted_at']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>