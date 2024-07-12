<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once 'dbConnect.php'; // Adjust the path as per your project structure

// Retrieve clerkID from session or set a default value
$clerkID = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$clerkType = isset($_SESSION['userType']) ? $_SESSION['userType'] : null;

if ($clerkID !== null) {
    // Check if a file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Process file upload
        $file = $_FILES['profile_picture'];

        // File properties
        $fileName = $file['name'];
        $fileTempName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // File extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        // Check if file type is allowed
        if (in_array($fileExt, $allowedExtensions)) {
            // Generate a unique file name
            $newFileName = 'profile_' . $clerkID . '.' . $fileExt;

            // File destination path
            $uploadPath = 'image/profile/' . $newFileName;

            // Move uploaded file to destination
            if (move_uploaded_file($fileTempName, $uploadPath)) {
                // Update profile picture path in the database
                $updateQuery = "UPDATE clerk SET CLERKIMAGE = ? WHERE CLERKID = ?";
                $stmt = $dbCon->prepare($updateQuery);
                $stmt->bind_param('si', $uploadPath, $clerkID);
                $stmt->execute();
                $stmt->close();

                // Redirect to profile page or display success message
                if ($clerkType == 'clerk') {
                    echo "<script>alert('Profile picture uploaded successfully.');
                    window.location.href = 'ClerkProfile.php'; </script>";
                } else if ($clerkType == 'admin') {
                    echo "<script>alert('Profile picture uploaded successfully.');
                    window.location.href = 'ClerkProfile.php'; </script>";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File type not supported. Please upload a JPG, JPEG, or PNG file.";
        }
    } else {
        echo "No file uploaded or an error occurred during upload.";
    }
} else {
    echo "Staff ID not found.";
}
?>
