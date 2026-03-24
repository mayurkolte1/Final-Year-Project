<?php
$name = $_POST['name'];
$date = $_POST['date'];
$sign = $_POST['sign'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#eee;
}

.certificate{
    width:1000px;
    height:700px;
    margin:30px auto;
    padding:40px;
    background:linear-gradient(135deg,#000,#222);
    color:white;
    text-align:center;
    border:12px solid gold;
}

.title{
    font-size:48px;
    color:gold;
    margin-top:40px;
}

.subtitle{
    font-size:20px;
    margin-top:10px;
}

.name{
    font-size:50px;
    margin:40px 0;
}

.footer{
    margin-top:80px;
    display:flex;
    justify-content:space-between;
    padding:0 80px;
}

button{
    padding:12px 25px;
    background:#4CAF50;
    color:white;
    border:none;
    margin:20px;
    cursor:pointer;
}
</style>

<script>
function downloadPDF(){
    window.print();
}
</script>

</head>

<body>

<div class="certificate">

<div class="title">CERTIFICATE</div>
<div class="subtitle">OF PARTICIPATION</div>

<p>This certificate is proudly presented to</p>

<div class="name"><?php echo $name; ?></div>

<p>For successfully participating with excellence.</p>

<div class="footer">
<div>Date: <?php echo $date; ?></div>
<div>Signature: <?php echo $sign; ?></div>
</div>

</div>

<div style="text-align:center;">
<button onclick="downloadPDF()">Download PDF</button>
</div>

</body>
</html>
