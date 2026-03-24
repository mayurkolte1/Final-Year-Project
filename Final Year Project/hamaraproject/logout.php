<?php
session_start();

/* ===== CONFIRMATION CHECK ===== */

if(isset($_GET['confirm']) && $_GET['confirm']=="yes"){

$conn = new mysqli("127.0.0.1:3306", "root", "", "certificate_db");

if ($conn->connect_error) {
    die("Database connection failed");
}

/* ===== UPDATE LOGOUT TIME ===== */

if (isset($_SESSION['user_id'])) {

    $uid = $_SESSION['user_id'];

    $result = $conn->query("
        SELECT id 
        FROM login_logs 
        WHERE user_id = '$uid'
        ORDER BY id DESC
        LIMIT 1
    ");

    if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $last_id = $row['id'];

        $conn->query("
            UPDATE login_logs 
            SET logout_time = NOW()
            WHERE id = '$last_id'
        ");
    }
}

session_unset();
session_destroy();

header("Location: home.html?logout=success");
exit();

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Logout Confirmation</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

/* ===== BACKGROUND ===== */

body{

height:100vh;

display:flex;
justify-content:center;
align-items:center;

/* 3D animated gradient */

background:linear-gradient(-45deg,#667eea,#764ba2,#ff6a00,#ee0979);

background-size:400% 400%;

animation:gradientMove 12s ease infinite;

}

@keyframes gradientMove{

0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}

}

/* ===== CARD ===== */

.box{

background:rgba(255,255,255,0.15);

backdrop-filter:blur(15px);

padding:45px;

border-radius:25px;

text-align:center;

width:380px;

/* glow effect */

box-shadow:

0 15px 40px rgba(0,0,0,0.4),

0 0 25px rgba(255,255,255,0.2);

animation:pop 0.5s ease;

}

@keyframes pop{

0%{transform:scale(0.8);opacity:0;}
100%{transform:scale(1);opacity:1;}

}

.icon{

font-size:55px;

margin-bottom:15px;

}

/* ===== TEXT ===== */

h2{

color:white;

margin-bottom:25px;

font-weight:600;

letter-spacing:1px;

}

/* ===== BUTTONS ===== */

.btn{

padding:12px 28px;

border:none;

border-radius:30px;

font-size:15px;

cursor:pointer;

margin:8px;

transition:0.3s;

font-weight:600;

}

/* YES BUTTON */

.yes{

background:linear-gradient(135deg,#ff416c,#ff4b2b);

color:white;

box-shadow:0 6px 20px rgba(0,0,0,0.4);

}

.yes:hover{

transform:translateY(-4px) scale(1.05);

box-shadow:0 10px 25px rgba(0,0,0,0.5);

}

/* CANCEL BUTTON */

.no{

background:white;

color:#333;

box-shadow:0 6px 20px rgba(0,0,0,0.4);

}

.no:hover{

transform:translateY(-4px) scale(1.05);

background:#f2f2f2;

}

</style>

</head>

<body>

<div class="box">

<div class="icon">⚠️</div>

<h2>Are you sure want to logout? Your current session will end and you will need to login again to access your account.</h2>

<a href="logout.php?confirm=yes">
<button class="btn yes">Yes Logout</button>
</a>

<a href="dashboard.php">
<button class="btn no">Cancel</button>
</a>

</div>

</body>
</html>