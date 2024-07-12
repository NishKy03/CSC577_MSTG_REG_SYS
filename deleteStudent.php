<?php
require_once("dbConnect.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: welcome.php"); // Redirect to login page if not logged in
    exit;
}

// Check if student ID is provided and valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $studentId = $_GET['id'];

    // Function to delete student record
    function deleteStudent($dbCon, $studentId) {
        $sql = "DELETE FROM student WHERE STUID = ?";
        $stmt = $dbCon->prepare($sql);
        $stmt->bind_param("s", $studentId);
        
        if ($stmt->execute()) {
            return true; // Deletion successful
        } else {
            return false; // Deletion failed
        }
        
        $stmt->close();
    }

    // Call deleteStudent function
    if (deleteStudent($dbCon, $studentId)) {
        // Successful deletion
        $_SESSION['delete_message'] = "Student record deleted successfully.";
    } else {
        // Deletion failed
        $_SESSION['delete_message'] = "Failed to delete student record.";
    }

    $dbCon->close();

    // Redirect back to listofstudent.php
    header("location: listofstudent.php");
    exit;
} else {
    // If no ID provided, redirect back to listofstudent.php
    header("location: listofstudent.php");
    exit;
}
?>