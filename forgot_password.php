<?PHP
    session_start();
    include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockWise: Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image" href="box-seam.svg">
    <style>
        body {
            background: #5842e3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 380px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        .form-group {
            margin-bottom: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            font-size: 13px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .password-requirements {
            font-size: 11px;
            color: #666;
        }
        button {
            background-color: #307ff3;
            color: white;
            border: none;
            padding: 8px 0;
            font-size: 14px;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
            margin-top: 8px;
        }
        button:hover {
            background-color: #2460c1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="bi bi-lock"></i> Change Password</h1>
        <form id="changePasswordForm" method="POST" action="<?php $_SERVER
   ['PHP_SELF']; ?>" class="pb-3">
            <div class="form-group">
                <label for="otp">OTP</label>
                <input type="text" id="otp" name="otp" placeholder="Enter OTP Sent to Your Email ID" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="New password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                <div class="password-requirements">Min 8 chars with letters, numbers & symbols</div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
            </div>
            <p class="email-info" id="emailInfo"></p>
            <button type="submit" name="reset">Reset Password</button>
        </form>
<?PHP
    if(isset($_POST['reset']))
    {
        $otp=$_POST['otp'];
        $npass=$_POST['newPassword'];
        $cpass=$_POST['confirmPassword'];
        if($npass!=$cpass)
        {
            echo "<div class='alert alert-danger' role='alert'>
  New Password and Confirm Password Should be Same!
</div>";
        }
        else
        {
            if($otp!=($_SESSION['token']))
            {
                echo "<div class='alert alert-danger' role='alert'>
  Invalid OTP!
</div>";
            }
            else
            {
                $email=$_SESSION['email'];
                $hpass=password_hash($npass, PASSWORD_DEFAULT);
                $sql="UPDATE `user` SET `Password`='$hpass' WHERE `Email`='$email'";
                $result=mysqli_query($con,$sql);
                session_destroy();
                echo "<script>alert('Password Changed Successfully, Kindly LogIn!')</script>";
                echo "<script>window.open('login.php','_self')</script>";
            }
        }
    }
?>
    </div>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const email = urlParams.get('email');
            if (email) {
                document.getElementById('emailInfo').textContent = `(Sent to ${email})`;
            }
        });

        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                return;
            }
            if (newPassword.length < 8) {
                return;
            }

            // Proceed with password reset (handle backend logic)
            window.location.href = "password-reset-success.html";
        });
    </script> -->
</body>
</html>
