<?php
require_once("../dbConnect.php");

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: welcome.php"); // Redirect to login page if not logged in
    exit;
}

// Determine the current page and the offset for the SQL query
$itemsPerPage = 5;
$currentStudentPage = isset($_GET['student_page']) ? (int)$_GET['student_page'] : 1;
$currentClerkPage = isset($_GET['clerk_page']) ? (int)$_GET['clerk_page'] : 1;

$studentOffset = ($currentStudentPage - 1) * $itemsPerPage;
$clerkOffset = ($currentClerkPage - 1) * $itemsPerPage;

// Get total number of students
$totalStudentsQuery = $dbCon->query("SELECT COUNT(*) FROM student");
$totalStudents = $totalStudentsQuery->fetch_row()[0];
$totalStudentPages = ceil($totalStudents / $itemsPerPage);

// Get total number of clerks
$totalClerksQuery = $dbCon->query("SELECT COUNT(*) FROM clerk");
$totalClerks = $totalClerksQuery->fetch_row()[0];
$totalClerkPages = ceil($totalClerks / $itemsPerPage);

// Prepare and execute the SQL statement to get student data with limit and offset
$stmtStudent = $dbCon->prepare("SELECT s.stuid, s.stuname, s.studob, s.stugender, s.stuaddress, r.status FROM student as s JOIN registration r ON s.stuid = r.stuid WHERE r.status = 'Approved' LIMIT ? OFFSET ?");
$stmtStudent->bind_param("ii", $itemsPerPage, $studentOffset);
$stmtStudent->execute();
$stmtStudent->store_result();
$stmtStudent->bind_result($studentId, $studentName, $studentDob, $studentGender, $studentAddress,$status);

// Prepare and execute the SQL statement to get clerk data with limit and offset
$stmtClerk = $dbCon->prepare("SELECT clerkid, clerkname, clerktype, clerkemail FROM clerk LIMIT ? OFFSET ?");
$stmtClerk->bind_param("ii", $itemsPerPage, $clerkOffset);
$stmtClerk->execute();
$stmtClerk->store_result();
$stmtClerk->bind_result($clerkid, $clerkname, $department, $contact);

function calculateAge($dob) {
    $dob = new DateTime($dob);
    $now = new DateTime();
    $age = $now->diff($dob);
    return $age->y;
}
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
.table-wrapper{
    width: 98%;
    padding: 40px;
    background-color: #fff;
    margin-left: 20px;
    margin-right: 20px;
    margin-top: 40px;
    border-radius: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid var(--primary-color);
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background-color: var(--primary-color);
    color: var(--sidebar-color);
}

tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination a {
    text-decoration: none;
    color: #007bff;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.pagination a:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination .active a {
    background-color: #007bff;
    color: #fff;
    cursor: default;
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
            <span class="profession"> Principal </span>
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
        <div class="dashboard-wrapper">Report</div>
        <div class="table-wrapper">
            <h2>Student List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Matric No.</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($stmtStudent->num_rows > 0) {
                        // Output data of each row for students
                        while ($stmtStudent->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($studentId) . "</td>";
                            echo "<td>" . htmlspecialchars($studentName) . "</td>";
                            echo "<td>" . (isset($studentDob) ? calculateAge($studentDob) : '-') . "</td>";
                            echo "<td>" . (isset($studentGender) ? htmlspecialchars($studentGender) : '-') . "</td>";
                            echo "<td>" . (isset($studentAddress) ? htmlspecialchars($studentAddress) : '-') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No students found</td></tr>";
                    }
                    $stmtStudent->close();
                    ?>
                </tbody>
            </table>
            <div>
                <?php if ($totalStudentPages > 1): ?>
                    <ul class="pagination">
                        <?php if ($currentStudentPage > 1): ?>
                            <li><a href="?student_page=<?php echo $currentStudentPage - 1; ?>&clerk_page=<?php echo $currentClerkPage; ?>">&laquo;</a></li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalStudentPages; $i++): ?>
                            <li><a href="?student_page=<?php echo $i; ?>&clerk_page=<?php echo $currentClerkPage; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($currentStudentPage < $totalStudentPages): ?>
                            <li><a href="?student_page=<?php echo $currentStudentPage + 1; ?>&clerk_page=<?php echo $currentClerkPage; ?>">&raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <h2>Clerk List</h2>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($stmtClerk->num_rows > 0) {
                        // Output data of each row for clerks
                        while ($stmtClerk->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($clerkid) . "</td>";
                            echo "<td>" . htmlspecialchars($clerkname) . "</td>";
                            echo "<td>" . htmlspecialchars($department) . "</td>";
                            echo "<td>" . htmlspecialchars($contact) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No clerks found</td></tr>";
                    }
                    $stmtClerk->close();
                    ?>
                </tbody>
            </table>
            <div>
                <?php if ($totalClerkPages > 1): ?>
                    <ul class="pagination">
                        <?php if ($currentClerkPage > 1): ?>
                            <li><a href="?student_page=<?php echo $currentStudentPage; ?>&clerk_page=<?php echo $currentClerkPage - 1; ?>">&laquo;</a></li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalClerkPages; $i++): ?>
                            <li><a href="?student_page=<?php echo $currentStudentPage; ?>&clerk_page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($currentClerkPage < $totalClerkPages): ?>
                            <li><a href="?student_page=<?php echo $currentStudentPage; ?>&clerk_page=<?php echo $currentClerkPage + 1; ?>">&raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
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

<?php
$dbCon->close();
?>