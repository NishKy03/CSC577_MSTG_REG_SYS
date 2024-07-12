<?php
require_once("dbConnect.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: welcome.php"); // Redirect to login page if not logged in
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

if (isset($_GET['id'])) {
    $stuID = $_GET['id'];
    $sql1 = "SELECT * FROM student WHERE STUID = ?";
    $stmt1 = $dbCon->prepare($sql1);
    $stmt1->bind_param("s", $stuID);
    if ($stmt1->execute()) {
        $result1 = $stmt1->get_result();
        $row = $result1->fetch_assoc();
        $STUID = $row['STUID'];
        $STUNAME = $row['STUNAME'];
        $STUPNO = $row['STUPNO'];
        $STUEMAIL = $row['STUEMAIL'];
        $STUGENDER = $row['STUGENDER'];
        $STUDOB = $row['STUDOB'];
        $STUADDRESS = $row['STUADDRESS'];
        $FATHERNAME = $row['FATHERNAME'];
        $MOTHERNAME = $row['MOTHERNAME'];
        $SALARY = $row['SALARY'];

        $stmt1->close();
    } else {
        echo "<script>alert('Error: " . $stmt1->error . "');</script>";
    }
} else {
    echo "<script>alert('Error: Student ID not set.');
    window.location.href = 'listofstudent.php'
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        .report-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-header h1 {
            margin: 0;
            font-size: 24px;
            color: #4CAF50;
        }
        .report-header img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .report-table th, .report-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .report-table th {
            background-color: #f4f4f9;
            color: #333;
            font-weight: bold;
        }
        .report-table td {
            background-color: #fff;
        }
        .print-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            margin-left: 50%;
        }
        .print-button:hover {
            background-color: #45a049;
        }
        @media print {
            .print-button {
                display: none;
            }
            .report-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            .report-table th, .report-table td {
                border: 1px solid #000;
            }
        }
    </style>
    <script>
        function printReport() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="report-container" id="report">
        <div class="report-header">
            <img src="logo.png" alt="School Logo"> <!-- Add your school logo here -->
            <h1>Student Report</h1>
        </div>
        <table class="report-table">
            <tr>
                <th>Student ID</th>
                <td><?= htmlspecialchars($STUID) ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?= htmlspecialchars($STUNAME) ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?= htmlspecialchars($STUPNO) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($STUEMAIL) ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= htmlspecialchars($STUGENDER) ?></td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td><?= htmlspecialchars($STUDOB) ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?= htmlspecialchars($STUADDRESS) ?></td>
            </tr>
            <tr>
                <th>Father's Name</th>
                <td><?= htmlspecialchars($FATHERNAME) ?></td>
            </tr>
            <tr>
                <th>Mother's Name</th>
                <td><?= htmlspecialchars($MOTHERNAME) ?></td>
            </tr>
            <tr>
                <th>Salary</th>
                <td>RM <?= htmlspecialchars($SALARY) ?></td>
            </tr>
        </table>
    </div>
    <button class="print-button" onclick="printReport()">Print Report</button>
</body>
</html>
