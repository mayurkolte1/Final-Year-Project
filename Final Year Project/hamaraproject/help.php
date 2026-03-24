<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.html");
    exit();
}

/* DB CONNECTION */
$conn = new mysqli("localhost","root","","certificate_db");
if($conn->connect_error){
    die("Database connection failed");
}

$msg = "";

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $problem = $_POST['problem'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg = "Invalid Email!";
    } else {

        $folder = "uploads/";
        if(!is_dir($folder)){
            mkdir($folder,0777,true);
        }

        if(isset($_FILES['screenshot']) && $_FILES['screenshot']['name']!=""){

            $fileName = time()."_".$_FILES['screenshot']['name'];
            $target = $folder.$fileName;

            if(move_uploaded_file($_FILES['screenshot']['tmp_name'],$target)){

                $sql = "INSERT INTO help_requests
                        (name,email,problem,screenshot)
                        VALUES
                        ('$name','$email','$problem','$target')";

                if($conn->query($sql)){
                    $msg = "Request Submitted Successfully!";
                } else {
                    $msg = "Insert Failed: ".$conn->error;
                }

            } else {
                $msg = "Image upload failed!";
            }

        } else {
            $msg = "Upload screenshot!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Help & Support</title>

<link rel="stylesheet" href="css/dashboard.css">

<style>
.section {
    padding: 60px 20px;
    text-align: center;
}

.help-form {
    width: 420px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.help-form input,
.help-form textarea {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.help-form button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, skyblue, #764ba2);
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
}

.help-form button:hover {
    opacity: 0.9;
}

.msg {
    margin-bottom: 15px;
    font-weight: bold;
    color: green;
}
</style>
</head>

<body>

<!-- SAME HEADER STRUCTURE AS DASHBOARD.PHP -->
<header class="logo">
    <div style="display: flex; align-items: center; gap: 8px; margin-left: 5px;">
        <img src="Images/logo5.jpeg" class="logo" style="margin-left:-45px;">
        <h1 style="margin-left: -5px;">
            <b><u>CERTIFICATE GENERATOR PORTAL</u></b>
        </h1>
    </div>

    <nav class="nav">
        <a href="abouts.php"><b>About</b></a>
        <a href="dashboard.php"><b>Template</b></a>
        <a href="help.php"><b>Help</b></a>
    </nav>

    <div class="right">
        <span style="color:#764ba2;font-size:20px;">
            <b>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></b>
        </span>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</header>

<section class="section">

<h2 style="color:white; margin-bottom:30px;">Help & Support</h2>

<div class="help-form">

<?php if($msg!="") echo "<div class='msg'>$msg</div>"; ?>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Enter Name" required>

<input type="email" name="email" placeholder="Enter Email" required>

<textarea name="problem" rows="4" placeholder="Describe your problem" required></textarea>

<label>Upload Screenshot</label>
<input type="file" name="screenshot" required>

<button type="submit" name="submit">Submit</button>

</form>

</div>

</section>

</body>
</html>