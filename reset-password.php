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
        <h1><i class="bi bi-envelope"></i> Reset Password</h1>
        <form id="otpForm" method="POST" action="<?php $_SERVER
   ['PHP_SELF']; ?>" class="pb-3">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" name="send">Send OTP</button>
        </form>
<?PHP
    if(isset($_POST['send']))
    {
        $email=$_POST['email'];
        $sql="SELECT * FROM `user` WHERE `Email`='$email'";
        $result=mysqli_query($con,$sql);
        $num=mysqli_num_rows($result);
        if($num>0)
        {
            $row=mysqli_fetch_assoc($result);
            $name=$row['Name'];
            $_SESSION['email']=$email;
            $token=rand(1000,9999);
            $_SESSION['token']=$token;
            sendemail_verify($name,$email,$token);
            echo "<script>window.open('forgot_password.php','_self')</script>";
        }
        else
        {
            echo "<div class='alert alert-danger' role='alert'>
  Invalid Email ID!
</div>";
        }
    }
?>
    </div>

    <!-- <script>
        document.getElementById('otpForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            if (email) {
                window.location.href = `change_password.html?email=${encodeURIComponent(email)}`;
            }
        });
    </script> -->
</body>
</html>
