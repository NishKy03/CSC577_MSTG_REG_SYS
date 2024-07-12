<?php
require_once("../dbConnect.php");

if (isset($_GET['clerkid'])) {
    $clerkId = $_GET['clerkid'];
    $sql = "SELECT * FROM clerk WHERE CLERKID = ?";
    $stmt = $dbCon->prepare($sql);
    $stmt->bind_param("i", $clerkId);
    $stmt->execute();
    $result = $stmt->get_result();
    $clerk = $result->fetch_assoc();
    $stmt->close();
} else {
    $clerk = null;
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
    <title>Clerk Profile</title>
    <style>
        .profile-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
            margin-left: 25px;
        }
        .profile-container .image-wrap {
            margin-top: 20px;
            margin-bottom: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 175px;
        }
        .profile-container .image-wrap img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }
        .profile-container p {
            font-size: 16px;
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
        }
        .profile-container p strong {
            display: block;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }
        .profile-container .icon-container {
            margin-top: 20px;
        }
        .profile-container .icon-container a {
            margin: 0 10px;
            color: #333;
            text-decoration: none;
            font-size: 20px;
        }
        .profile-container .icon-container a:hover {
            color: #007bff;
        }
        .edit-container {
            display: none;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
            margin-left: 25px;
        }
        .edit-container form {
            display: flex;
            flex-direction: column;
        }
        .edit-container form label {
            font-size: 16px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .edit-container form input {
            font-size: 16px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .edit-container form button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-container form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <?php if ($clerk): ?>
            <div class="image-wrap">
                <img src="<?php echo '../' . htmlspecialchars($clerk['CLERKIMAGE']); ?>" alt="Profile Picture">
            </div>
            <h2><?php echo htmlspecialchars($clerk['CLERKNAME']); ?></h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($clerk['CLERKEMAIL']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($clerk['CLERKPNO']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($clerk['CLERKDOB']); ?></p>
            <div class="icon-container">
                <a href="editclerk.php?clerkid=<?php echo $clerkId; ?>"><i class="fa fa-pencil"></i></a>
                <a href="deleteclerk.php?clerkid=<?php echo $clerkId; ?>" onclick="return confirm('Are you sure you want to delete this clerk?');"><i class="fa fa-trash"></i></a>
                <a href="#" onclick="printProfile()"><i class="fa fa-print"></i></a>
            </div>
            <?php else: ?>
            <p>No profile details found for this clerk.</p>
        <?php endif; ?>
    </div>
    <div class="edit-container">
        <h2>Edit Clerk</h2>
        <form method="post" action="">
            <label for="clerkname">Name</label>
            <input type="text" id="clerkname" name="clerkname" value="<?php echo htmlspecialchars($clerk['CLERKNAME']); ?>" required>
            
            <label for="clerkemail">Email</label>
            <input type="email" id="clerkemail" name="clerkemail" value="<?php echo htmlspecialchars($clerk['CLERKEMAIL']); ?>" required>
            
            <label for="clerkpno">Phone</label>
            <input type="text" id="clerkpno" name="clerkpno" value="<?php echo htmlspecialchars($clerk['CLERKPNO']); ?>" required>
            
            <label for="clerkdob">Date of Birth</label>
            <input type="date" id="clerkdob" name="clerkdob" value="<?php echo htmlspecialchars($clerk['CLERKDOB']); ?>" required>
            
            <button type="submit">Save Changes</button>
        </form>
    </div>
    <script>
        function showEditForm() {
            document.querySelector('.profile-container').style.display = 'none';
            document.querySelector('.edit-container').style.display = 'block';
        }
        function printProfile() {
            window.print();
        }
    </script>
</body>
</html>