<?php
require_once("../dbConnect.php");

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: welcome.php"); // Redirect to login page if not logged in
    exit;
}

// Query to get total count of clerks
$stmtClerkCount = $dbCon->prepare("SELECT COUNT(*) AS total_clerks FROM clerk");
$stmtClerkCount->execute();
$stmtClerkCount->bind_result($totalClerks);
$stmtClerkCount->fetch();
$stmtClerkCount->close();

// Query to get total count of students
$stmtStudentCount = $dbCon->prepare("SELECT COUNT(*) AS total_students FROM student");
$stmtStudentCount->execute();
$stmtStudentCount->bind_result($totalStudents);
$stmtStudentCount->fetch();
$stmtStudentCount->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Arial:wght@700&display=swap" />
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

:root{
    /* ===== Colors ===== */
    --body-color: #ECE8C6;
    --sidebar-color: #FFF;
    --primary-color: #9F9A6A;
    --primary-color-light: #F6F5FF;
    --toggle-color: #DDD;
    --text-color: #707070;

    /* ====== Transition ====== */
    --tran-03: all 0.2s ease;
    --tran-03: all 0.3s ease;
    --tran-04: all 0.3s ease;
    --tran-05: all 0.3s ease;
}

body{
    min-height: 100vh;
    background-color: var(--body-color);
    transition: var(--tran-05);
}

::selection{
    background-color: var(--primary-color);
    color: #fff;
}

body.dark{
    --body-color: #18191a;
    --sidebar-color: #242526;
    --primary-color: #3a3b3c;
    --primary-color-light: #3a3b3c;
    --toggle-color: #fff;
    --text-color: #634711;
}

/* ===== Sidebar ===== */
 .sidebar{
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    padding: 10px 14px;
    background: var(--sidebar-color);
    transition: var(--tran-05);
    z-index: 100;  
}
.sidebar.close{
    width: 88px;
}

/* ===== Reusable code - Here ===== */
.sidebar li{
    height: 50px;
    list-style: none;
    display: flex;
    align-items: center;
    margin-top: 10px;
}

.sidebar header .image,
.sidebar .icon{
    min-width: 60px;
    border-radius: 6px;
}

.sidebar .icon{
    min-width: 60px;
    border-radius: 6px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.sidebar .text,
.sidebar .icon{
    color: var(--text-color);
    transition: var(--tran-03);
}

.sidebar .text{
    font-size: 17px;
    font-weight: 500;
    white-space: nowrap;
    opacity: 1;

}
.sidebar.close .text{
    opacity: 0;
}
/* =========================== */

.sidebar header{
    position: relative;
}
.sidebar header .logo-text{
    display: flex;
    flex-direction: column;
    text-align: center;
    margin-top: 10px;
}
header .name {
    margin-top: 2px;
    font-size: 18px;
    font-weight: 600;
}

header .image-text .profession{
    font-size: 16px;
    margin-top: -2px;
    display: block;
}

.sidebar header .image{
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 40px;
}

.sidebar header .image img{
    width: 70px;
    border-radius: 6px;
}

.sidebar header .toggle{
    position: absolute;
    top: 50%;
    right: -25px;
    transform: translateY(-50%) rotate(180deg);
    height: 25px;
    width: 25px;
    background-color: var(--primary-color);
    color: var(--sidebar-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    cursor: pointer;
    transition: var(--tran-05);
}

body.dark .sidebar header .toggle{
    color: var(--text-color);
}

.sidebar.close .toggle{
    transform: translateY(-50%) rotate(0deg);
}

.sidebar .menu{
    margin-top: 20px;
}

.sidebar li.search-box{
    border-radius: 6px;
    background-color: var(--primary-color-light);
    cursor: pointer;
    transition: var(--tran-05);
}

.sidebar li.search-box input{
    height: 100%;
    width: 100%;
    outline: none;
    border: none;
    background-color: var(--primary-color-light);
    color: var(--text-color);
    border-radius: 6px;
    font-size: 17px;
    font-weight: 500;
    transition: var(--tran-05);
}
.sidebar li a{
    list-style: none;
    height: 100%;
    background-color: transparent;
    display: flex;
    align-items: center;
    height: 100%;
    width: 100%;
    border-radius: 6px;
    text-decoration: none;
    transition: var(--tran-03);
}

.sidebar li a:hover{
    background-color: var(--primary-color);
}
.sidebar li a:hover .icon,
.sidebar li a:hover .text{
    color: var(--sidebar-color);
}
body.dark .sidebar li a:hover .icon,
body.dark .sidebar li a:hover .text{
    color: var(--text-color);
}

.sidebar .menu-bar{
    height: calc(100% - 55px);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow-y: scroll;
}
.menu-bar::-webkit-scrollbar{
    display: none;
}
.sidebar .menu-bar .mode{
    border-radius: 6px;
    background-color: var(--primary-color-light);
    position: relative;
    transition: var(--tran-05);
}

.menu-bar .mode .sun-moon{
    height: 50px;
    width: 60px;
}

.mode .sun-moon i{
    position: absolute;
}
.mode .sun-moon i.sun{
    opacity: 0;
}
body.dark .mode .sun-moon i.sun{
    opacity: 1;
}
body.dark .mode .sun-moon i.moon{
    opacity: 0;
}

.menu-bar .bottom-content .toggle-switch{
    position: absolute;
    right: 0;
    min-width: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    cursor: pointer;
    top: -100px;
}
.toggle-switch .switch{
    position: relative;
    height: 22px;
    width: 40px;
    border-radius: 25px;
    background-color: var(--toggle-color);
    transition: var(--tran-05);
}

.switch::before{
    content: '';
    position: absolute;
    height: 15px;
    width: 15px;
    border-radius: 50%;
    top: 50%;
    left: 5px;
    transform: translateY(-50%);
    background-color: var(--sidebar-color);
    transition: var(--tran-04);
}

body.dark .switch::before{
    left: 20px;
}

.home{
    position: absolute;
    top: 0;
    top: 0;
    left: 250px;
    height: 100vh;
    width: calc(100% - 250px);
    background-color: var(--body-color);
    transition: var(--tran-05);
}
.dashboard-wrapper{
    font-size: 30px;
    font-weight: 500;
    color: var(--text-color);
    padding: 12px 40px;
    background: white;
    margin-top: 20px;
    margin-left: 20px;
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
}

.sidebar.close ~ .home{
    left: 78px;
    height: 100vh;
    width: calc(100% - 78px);
}
body.dark .home .text{
    color: var(--text-color);
}
.content-in {
    width: 100%;
    display: flex; /* Ensure the child elements are in a row */
    align-items: flex-start; /* Align items at the top */
    gap: 20px; /* Optional: Add space between boxes */
    margin-top: 40px;
    margin-left: 20px;
    padding: 10px;
}

.show-box1, .show-box2, .show-box3, .show-box4, .show-box5, .show-box6{
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    background-color: white;
}
.show-box1{
    display: inline-block;
    width: 300px;
    margin-left: 40px;
    margin-right: 100px;
    padding: 20px;
    text-align: right;
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
}
.show-box2{
    display: inline-block;
    width: 300px;
    border: 1px solid #ccc;
    margin-right: 100px;
    padding: 20px;
    text-align: right;
    position: relative;
    border-radius: 10px;
}
.show-box3{
    display: inline-block;
    width: 300px;
    border: 1px solid black;
    padding: 20px;
    text-align: right;
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
}
.icon-class1, .icon-class2, .icon-class3, .icon-class4 {
    position: absolute;
    width: 60px;
    height: 60px;
    justify-content: center;
    align-items: center;
    margin-top: -80px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow */
    display: flex; /* Ensure flex layout for centering */
    color: white;
    font-size: 25px;
}
.icon-class1{
    background: #4caf50;
}
.icon-class2{
    background: #0492c2;
}
.icon-class3{
    background: #f09c48;
}
.icon-class4{
    background: #ffea17;
}
.content-in h3 {
    font-size: 18px;
    color: grey;
    margin-bottom: 10px;
}
.content-in p{
    font-size: 25px;
}

</style>
<body>
    <nav class="sidebar close">
        <header>
            <span class="image">
                <img src="../ClerkImage/chibi.jpg" alt="">
            </span>
            <div class="text logo-text">
                <span class="name">Welcome!</span>
                <span class="profession">Principal</span>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="../PRINCIPAL/PrincipalDashboard.php">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../PRINCIPAL/report.php">
                            <i class='bx bx-bar-chart-alt-2 icon' ></i>
                            <span class="text nav-text">Report</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="logout.php">
                            <i class='bx bx-log-out icon' ></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    <section class="home">
        <div class="dashboard-wrapper">Dashboard</div>
        <div class="content-in"> 
            <div class="show-box1">
                <h3>Total Clerk</h3>
                <div class="icon-class1">
                    <span><i class="fa fa-users" aria-hidden="true"></i></span>
                </div>
                <p><b><?php echo $totalClerks; ?></b></p>
            </div>
            <div class="show-box2">
                <h3>Total Student</h3>
                <div class="icon-class2">
                    <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                </div>
                <p><b><?php echo $totalStudents; ?></b></p>
            </div>
            <div class="show-box2">
                <h3>Total Approved</h3>
                <div class="icon-class3">
                    <span><i class="fas fa-calendar-check"></i></span>
                </div>
                <p><b>10</b></p>
            </div>
            <div class="show-box3">
                <h3>Total Unapproved</h3>
                <div class="icon-class4">
                    <span><i class="fa fa-spinner" aria-hidden="true"></i></span>
                </div>
                <p><b>5</b></p>
            </div>
        </div>
        
    </section>

    <script>
        const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");


toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
})

searchBtn.addEventListener("click" , () =>{
    sidebar.classList.remove("close");
})

modeSwitch.addEventListener("click" , () =>{
    body.classList.toggle("dark");
    
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
    }else{
        modeText.innerText = "Dark mode";
        
    }
});
    </script>

</body>
</html>