<?php
require_once("dbConnect.php");

$STUID = $STUNAME = $STUEMAIL = $STUPNO = $STUPASSWORD = $confirm_password = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $STUNAME = trim($_POST['STUNAME']);
    $STUEMAIL = trim($_POST['STUEMAIL']);
    $STUPNO = trim($_POST['STUPNO']);
    $STUPASSWORD = trim($_POST['STUPASSWORD']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($STUPASSWORD !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Check the highest STUID and increment it by 1
        $sql = "SELECT MAX(STUID) AS max_id FROM STUDENT";
        $result = $dbCon->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $STUID = $row['max_id'];
            if ($STUID) {
                $newID = str_pad((int)$STUID + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newID = '001';
            }
        } else {
            $newID = '001';
        }

        // Insert the new student into the database
        $sql = "INSERT INTO STUDENT (STUID, STUNAME, STUPNO, STUEMAIL, STUPASSWORD, STATUS) VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt = $dbCon->prepare($sql);
        $stmt->bind_param('sssss', $newID, $STUNAME, $STUPNO, $STUEMAIL, $STUPASSWORD);

        if ($stmt->execute()) {
            echo "<script>alert('Successfully registered. Your student ID is " . $newID . ". You can continue to login.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        // Close the statement and the connection
        $stmt->close();
        $dbCon->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Arial:wght@700&display=swap" />
    <title>Sign Up</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    body {
        width: 100%;
        background-color: #E2E0E0;
        background-size: cover;
        display: flex;
        align-items: center;
        flex-direction: column;
    }
    .wrapper {
        width: 600px;
        height: 800px;
        margin-top: 4%;
        background-color: white;
        border-radius: 30px;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    }
    .wrapper h1 {
        text-align: center;
        font-weight: 200;
        padding-top: 50px;
        padding-bottom: 15px;
        font-size: 60px;
        letter-spacing: 0.05em;
    }
    .wrapper input[type="text"],
    .wrapper input[type="password"] {
        margin-top: 10px;
        margin-left: 100px;
        margin-bottom: 20px;
        font-size: 20px;
        padding-bottom: 20px;
        width: 390px;
        border-bottom-color: black;
        border-left: none;
        border-right: none;
        border-top: none;
        outline: none;
    }
    .wrapper input[type="submit"] {
        padding: 10px;
        width: 390px;
        height: 45px;
        font-size: 15px;
        margin-left: 100px;
        background-color: #CDB433;
        border: none;
        font-weight: bold;
        color: aliceblue;
        border-radius: 5px;
        cursor: pointer;
    }
    .wrapper input[type="submit"]:hover {
        text-decoration: underline;
        background-color: #b8a549;
    }
    .line1,
    .line2 {
        border: 1px solid grey;
        width: 150px;
        display: inline-block;
        align-items: center;
        justify-content: center;
    }
    .line1 {
        margin-top: 27px;
        margin-left: 130px;
    }
    .line2 {
        margin-top: 27px;
    }
    .already-have-account {
        margin-top: 30px;
        margin-left: 180px;
        font-family: 'Inter';
        color: rgba(0, 0, 0, 0.705);
    }
    .already-have-account a {
        margin-left: 10px;
        text-decoration: none;
        color: black;
    }
    .already-have-account a:hover {
        text-decoration: underline;
    }
</style>
<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="return validateForm()">
            <h1>Sign Up</h1>
            <p style="text-align: center; font-family: inter; color: rgba(0, 0, 0, 0.705); padding-bottom: 30px;">Create a new account</p>
            
            <input type="text" name="STUNAME" id="STUNAME" placeholder="Enter full name" required><br>
            <input type="text" name="STUEMAIL" id="STUEMAIL" placeholder="Enter email" required><br>
            <input type="text" name="STUPNO" id="STUPNO" placeholder="Enter phone no" required><br>
            <input type="password" name="STUPASSWORD" id="STUPASSWORD" placeholder="Enter password" required><br>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required><br>
            <input type="submit" name="submit" value="SIGN UP">
        </form>
        
        <div class="line1"></div> 
        <p style="display: inline-block;">or</p> 
        <div class="line2"></div>

        <div class="already-have-account">
            <p>Already have an account? <a href="login.php"><b>Login</b></a></p>
        </div>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById("STUPASSWORD").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
