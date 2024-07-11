<?php
require_once("../dbConnect.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../welcome.php"); // Redirect to login page if not logged in
    exit;
}

$username = $_SESSION['username'];

// Fetch the list of clerks
$sql = "SELECT * FROM clerk where CLERKTYPE='clerk'";
$result = $dbCon->query($sql);

$clerks = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Extract the first two words from the CLERKNAME
        $fullName = $row['CLERKNAME'];
        $words = explode(' ', $fullName);
        $firstTwoWords = implode(' ', array_slice($words, 0, 2));
        
        // Assign the modified name back to the row
        $row['CLERKNAME'] = $firstTwoWords;

        // Prepend '../' to the CLERKIMAGE path
        $row['CLERKIMAGE'] = '../' . $row['CLERKIMAGE'];

        // Store the modified row in the clerks array
        $clerks[] = $row;
    }
}

$dbCon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <title>List of Clerk</title>
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
	background: #EFD577;
	color: white;
}
.welcome-name {
	font-size: 25px;
	margin-left: 40px;
}
.header i {
	font-size: 30px;
	cursor: pointer;
	color: black;
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
    background: #EFD577;
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
    border-bottom: 1px solid #ccc;
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
.line1{
    display: flex;
    width: 100%;
    justify-content: right;
    align-items: center;

}
.search-bar {
    margin-top: 20px;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 15px;
}
.search-bar input[type="text"] {
    flex: 1;
    border: none;
    outline: none;
    font-size: 18px;
    padding: 8px;
}
.search-bar button {
    background-color: transparent;
    color: grey;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 10px;
}
.search-bar i{
    font-size: 20px;
}
.search-bar button:hover {
    color: black;
}
.add-clerk {
    background-color: #4C1CD5;
    margin-right: 40px;
    margin-left: 40px;
    margin-top: 15px;
    border-radius: 15px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 15px;
    transition: background-color 0.3s; /* Added transition for background color change */
    color: white;
    text-decoration: none; /* Ensure it behaves like a button or link */
}

.add-clerk:hover {
    background-color: #5e28e4; /* Darker shade on hover */
    color: white; /* Ensure text remains white on hover */
}

.add-clerk a{
    text-decoration: none;
    color: white;
    font-size: 18px;
    padding: 10px 15px;
}
.add-clerk i{
    margin-right: 5px;
}
.list-clerk{
    width: 80%;
    background: #E7E4E4;
    padding: 30px;
    border-radius: 10px;
    margin-top: 40px;
}
.clerk-profile {
    width: 350px;
    background: #fff;
    display: flex;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adding a subtle shadow */
}

.image-wrap{
    border-radius: 50%;
    width: 80px;
    height: 80px;
    margin-left: 10px;
}
.image-wrap img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
.clerk-profile table{
    margin-left: 20px;
    width: 200px;
    
}
.clerk-profile table th{
    font-size: 20px;
    font-family: "Poppins", sans-serif;
    text-align: left;
}
.clerk-profile table td{
    font-size: 15px;
    font-family: "Poppins", sans-serif;
    text-align: left;
    line-height: 1.5;
}
.clerk-profile a{
    text-decoration: none;
    font-weight: bold;
}
.clerk-profile a:hover{
    color: grey;
}
</style>
<body>
    <input type="checkbox" id="checkbox">
    <div class="header">
        <label for="checkbox">
            <i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
        </label>
    </div>
    <div class="body">
        <nav class="side-bar">
            <div class="user-p">
                <img src="../logo.png" alt=""/>
            </div>
            <ul>
                <li>
                    <a href="AdminDashboard.php">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>DASHBOARD</span>
                    </a>
                </li>
                <li>
                    <a href="adminprofile.php">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>PROFILE</span>
                    </a>
                </li>
                <li style="border-bottom: 1px solid grey;">
                    <a href="listofclerk.php">
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
            <div class="circled-menu-parent">
                <p><i class="fa fa-th-large" style="font-size:25px;"></i>List of Clerk</p>
            </div>
            <div class="line1">
                <div class="search-bar">
                    <input type="text" placeholder="Search here">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
                <div class="add-clerk">
                    <a href="addclerk.php"><i class="fa fa-user-plus" aria-hidden="true"></i>Add Clerk</a>
                </div>
            </div>
            <div class="list-clerk">
                <table >
                    <tr>
                    <?php foreach ($clerks as $clerk): ?>
                        <td>
                            <div class="clerk-profile">
                                <div class="image-wrap">
                                
                                <img src="<?php echo htmlspecialchars($clerk['CLERKIMAGE']); ?>" alt="Profile Picture">
                                </div>
                                <table>
                                    <tr>
                                        <th><?php echo htmlspecialchars($clerk['CLERKNAME']); ?></th>
                                    </tr>
                                    <tr>
                                        <td><span style="color: grey;"><?php echo $clerk['CLERKEMAIL']; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="viewclerk.php?clerkid=<?php echo $clerk['CLERKID']; ?>">View Profile</a></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
