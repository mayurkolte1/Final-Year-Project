<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>About</title>
<link rel="stylesheet" href="dashboard1.css">

<style>
/* Section */
.section {
    padding: 40px;
    text-align: center;
}
/* Developer Cards */
.dev-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 25px;
    margin-top: 30px;
}

.dev-card {
    width: 250px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 20px;
    transition: 0.3s;
}

.dev-card:hover {
    transform: translateY(-5px);
}

.dev-card h3 {
    margin: 10px 0 5px;
    color: #333;
}

.dev-card p {
    color: #666;
    font-size: 14px;
}

/* Optional avatar circle */
.dev-avatar {
    width: 80px;
    height: 80px;
    background: #4CAF50;
    color: white;
    border-radius: 50%;
    line-height: 80px;
    font-size: 28px;
    margin: auto;
}
</style>

</head>

<body>

<header class="navbar">
    <div style="display: flex; align-items: center; margin-left: -35px;">
        <img src="Images/logo5.jpeg" class="logo">
        <span style="color: #764ba2; font-size: 22px; font-weight: bold; margin-left: 10px;"><b><u>CERTIFICATE GENERATOR PORTAL</u></b></span>
    </div>

    <div class="nav-menu">
        <a href="dashboard.php" class="nav-btn">Home</a>
        <a href="logout.php" class="nav-btn logout">Sign Out</a>
    </div>
</header>

<section class="section">
    <h2>About Portal</h2>
    <p>This system allows instant certificate generation quickly and efficiently.</p>

    <h2 style="margin-top:40px;">Developers Team</h2>

    <div class="dev-container">

        <div class="dev-card">
            <div class="dev-avatar">MK</div>
            <h3>Mayur Kolte</h3>
        </div>

        <div class="dev-card">
            <div class="dev-avatar">YM</div>
            <h3>Yashraj Modhe</h3>
        </div>

        <div class="dev-card">
            <div class="dev-avatar">RG</div>
            <h3>Ritesh Gavhad</h3>
        </div>

        <div class="dev-card">
            <div class="dev-avatar">CK</div>
            <h3>Chandrashekhar Kotkar</h3>
        </div>

    </div>

</section>

</body>
</html>