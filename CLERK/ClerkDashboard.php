<?php
require_once("../dbConnect.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../welcome.php"); // Redirect to login page if not logged in
    exit;
}

$username = $_SESSION['username'];

// Fetch the student's full name
$sql = "SELECT CLERKNAME FROM clerk WHERE CLERKID = ?";
$stmt = $dbCon->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($fullName);
$stmt->fetch();
$stmt->close();

$firstName = strtoupper(strtok($fullName, ' '));

$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <title>Clerk Dashboard</title>
</head>
<style>
* {
	padding: 0;
	margin: 0;
	box-sizing: border-box;
	font-family: arial, sans-serif;
}
.header {
	display: flex;
	align-items: center;
	padding: 28px 30px;
	background: #BF612D;
	color: white;
}
.welcome-name {
	font-size: 25px;
	margin-left: 40px;
}
.header i {
	font-size: 30px;
	cursor: pointer;
	color: #black;
}
.header a{
    text-decoration: none;
    color: black;
}
.header i:hover {
	color: #127b8e;
}
.right-icon {
	margin-left: auto;
}
.right-icon i {
	margin-right: 15px; 
}
.right-icon i:last-child {
	margin-right: 0; 
}
.user-p {
	text-align: center;
	padding-top: 50px;
}
.user-p img {
	width: 150px;
    height: 150px;
	border-radius: 50%;
}
.body {
	display: flex;
}
.side-bar {
    width: 350px;
    background: #AFAA79;
    min-height: 100vh;
    transition: 500ms width;
}
.side-bar ul {
    margin-top: 40px;
    list-style: none;
    border-top: 2px solid white;
}
.side-bar ul li {
    font-size: 20px;
    padding: 25px 0px;
    padding-left: 25px;
    transition: background 500ms;  /* Fixed transition property */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border: none;
    border-top: 1px solid grey;  /* Fixed border syntax */
}

.side-bar ul li:hover {
    background: #48332E;
    font-weight: bold;
}
.side-bar ul li:hover > ul {
    display: block; /* Display submenu on hover */
}
.side-bar ul li a {
    text-decoration: none;
    color: white;
    cursor: pointer;
    letter-spacing: 1px;
}
.side-bar  i {
    display: inline-block;
    padding-right: 10px;
    width: 30px;
    vertical-align: center;
    font-size: 25px;
    color: white;
}
.side-bar ul li a {
    text-decoration: none;
    color: #black;
    cursor: pointer;
    letter-spacing: 1px;
}
.side-bar ul li a i {
    display: inline-block;
    padding-right: 10px;
    font-size: 30px;
}
.section-1 {
    width: 100%;
    background-color: #F5EFE7;
    background-size: cover;
    background-position: center;
    display: flex; 
    align-items: center; 
    flex-direction: column;
    
}
#navbtn {
    display: inline-block;
    left: 20px;
    font-size: 20px;
    transition: 500ms color;
    color: #black;
}
#checkbox {
    display: none;
}
#checkbox:checked ~ .body .side-bar {
    width: 80px;
}
#checkbox:checked ~ .body .side-bar .user-p{
    visibility: hidden;
}
#checkbox:checked ~ .body .side-bar a span{
    display: none;
}
.circled-menu-parent{
    background-color: #f7f7f7;
    height: 60px;
    font-size: 25px;
    font-family: 'Inter';
    font-weight: bold;
    color: #434343;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    padding: 0 20px;
    font-family: "Poppins", sans-serif;
}

.circled-menu-parent p{
    margin: 0; /* Remove default margins to prevent alignment issues */
    display: flex; /* Use flexbox to align the icon and text */
    align-items: center; /* Vertically center the icon and text */
    font-size: 25px;
    font-family: "Poppins", sans-serif;
}

.circled-menu-parent i {
    margin-left: 20px;
    margin-right: 15px; /* Space between the icon and text */
}

.slider {
    width: 100%;
    overflow: hidden;
	position: relative;
}
.images {
    display: flex;
    width: 100%;
}
.images img {
    height: 450px;
    width: 100%;
    transition: all 0.15s ease;
}
.images input {
    display: none;
}
.dots {
    display: flex;
    justify-content: center;
    margin: 5px;
}
.dots label {
    height: 20px;
    width: 20px;
    border-radius: 50%;
    border: solid #fff 3px;
    cursor: pointer;
    transition: all 0.15s ease;
    margin: 5px;
}
.dots label:hover {background: #fff;}
#img1:checked ~ .m1 {
    margin-left: 0;
}
#img2:checked ~ .m2 {
    margin-left: -100%;
}
#img3:checked ~ .m3 {
    margin-left: -200%;
}
#img4:checked ~ .m4 {
    margin-left: -300%;
}
.latest-infographic {
    background-color: #f7f7f7;
    height: 70px;
    font-size: 25px;
    background-color: #6eabe3;
    color: white;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    font-weight: bold;
}
.infodisplay{
    width: 100%;
    display: flex;
    justify-content: center;
}
.graduation-cap-parent{
    margin-top: 70px;
    padding-top: 30px;
    background-color: white;
    width: 250px;
    height: 200px;
    text-align: center;
    font-size: 30px;
}
.hostel-parent{
    margin-top: 70px;
    margin-left: 100px;
    padding-top: 42px;
    background-color: white;
    width: 250px;
    height: 200px;
    text-align: center;
    font-size: 30px;
}
.management-parent{
    margin-top: 70px;
    margin-left: 100px;
    padding-top: 42px;
    background-color: white;
    width: 250px;
    height: 200px;
    text-align: center;
    font-size: 30px;
}

</style>
<body>
    <input type="checkbox" id="checkbox">
    <div class="header">
        <label for="checkbox">
            <i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
        </label>
        <h2 class="welcome-name">Welcome <span style="color: #48332E;"><?php echo htmlspecialchars($firstName); ?></span> !</h2>
        <div class="right-icon">
            <a href="studentprofile.php">
                <i class="fa fa-user" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <div class="body">
        <nav class="side-bar">
            <div class="user-p">
                <img src="../logo.png" alt=""/>
            </div>
            <ul>
                <li >
                    <a href="ClerkDashboard.php">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span style="padding-left:10px;">DASHBOARD</span>
                    </a>
                </li>
                <li>
                    <a href="ClerkProfile.php">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span style="padding-left:10px;">PROFILE</span>
                    </a>
                </li>
                <li>
                    <a href="listofstudent.php">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span style="padding-left:10px;">LIST OF STUDENT</span>
                    </a>
                </li>
                <li style="border-bottom: 1px solid grey;">
                    <a href="logout.php">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span style="padding-left:10px;">LOGOUT</span>
                    </a>
                </li>
            </ul>
        </nav>
        
    </div>
</body>
</html>
