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

$sql = "SELECT * FROM student";
$result = $dbCon->query($sql);

$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <title>View Student</title>
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
	color: white;
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
    position: relative;
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
.form-wrapper{
    margin-top: 60px;
    width: 80%;
    position: relative;
}
.personal-class {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
    background: white;
    overflow: hidden;
    border-radius: 20px;
    
}

.personal-class th {
    width: 100%;
    font-size: 20px;
    font-family: 'Poppins', sans-serif;
    letter-spacing: 0.05em;
    background-color: #8D3A0B;
    padding: 15px;
    border-top-left-radius: 20px; /* Corrected property */
    border-top-right-radius: 20px; /* Corrected property */
    padding-left: 20px;
    border-bottom: 1px solid #ccc; /* Add bottom border to table headers */
    text-align: left;
    overflow: hidden;
    color: white;
}

.personal-class td {
    padding: 15px;
    font-size: 18px;
    line-height: 1.5;
}
input[type="text"], input[type="date"], select {
    padding: 10px 15px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 18px;
    margin-bottom: 5px;
}
input[type="submit"]
{
    position: absolute;
    padding: 10px 15px;
    font-size: 18px;
    background: #DCB012;
    left: 84%;
    border: 1px solid #ccc;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: 700;
    border-radius: 5px;
    color: #634711;
}
input[type="submit"]:hover
{
    background-color: #C79D07;
}

.back-button {
    background: none;
    border: none;
    position: absolute;
    font-size: 25px;
    color: black;
    left: 80px;
    top: 60px;
}
.back-button a:hover{
    color: grey;
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
            <li>
                    <a href="ClerkDashboard.php">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>DASHBOARD</span>
                    </a>
                </li>
                <li>
                    <a href="ClerkProfile.php">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>PROFILE</span>
                    </a>
                </li>
                <li style="border-bottom: 1px solid grey;">
                    <a href="listclerk.php">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <span>LIST OF CLERK</span>
                    </a>
                </li>
                <li style="border-bottom: 1px solid grey;">
                    <a href="../logout.php">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span>LOGOUT</span>
                    </a>
                </li>
            </ul>
        </nav>
        <section class="section-1">
            <button class="back-button"><a href="listofstudent.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></button>
                <form action="" class="form-wrapper">
                    <table class="personal-class">
                        <tr>
                            <th colspan="2">
                                Personal Details
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <b>Name <span style="color: red;">*</span></b><br>
                                <input type="text" name="STUNAME" required>
                            </td>
                            <td>
                                <b>Phone Number <span style="color: red;">*</span></b><br>
                                <input type="text" name="STUNAME" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Date of Birth <span style="color: red;">*</span></b><br>
                                <input type="date" name="STUDOB" required>
                            </td>
                            <td>
                                <b>Gender <span style="color: red;">*</span></b><br>
                                <select name="STUGENDER" id="STUGENDER" required>
                                    <option value="m">Male</option>
                                    <option value="f">Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Address <span style="color: red;">*</span></b><br>
                                <input type="text" name="STUADDRESS" required>
                            </td>
                            <td>
                                <b>Email<span style="color: red;">*</span></b><br>
                                <input type="text" name="STUEMAIL" required>
                            </td>
                        </tr>
                    </table>
                    <table class="personal-class">
                        <tr>
                            <th colspan="2">
                                Parents Details
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <b>Father Name <span style="color: red;">*</span></b><br>
                                <input type="text" name="FATHERNAME" required>
                            </td>
                            <td>
                                <b>Mother Name <span style="color: red;">*</span></b><br>
                                <input type="text" name="MOTHERNAME" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Salary (RM)<span style="color: red;">*</span></b><br>
                                <input type="text" name="SALARY" required>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" value="Update Information">
                </form>
        </section>
    </div>
</body>
</html>

