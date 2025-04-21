<?php
    session_start();
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockWise: Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="front.css">
    <link rel="icon" type="image" href="box-seam.svg">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Login</h2>
        
        <form id="loginForm" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="form-group mb-3">
                <label for="email">Email ID: <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="password">Password: <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-success w-100" name="log">Login</button>
        </form>
        
        <div class="text-center mt-3">
            <p>New user? <a href="register.php" id="goToSignup">Sign up</a></p>
        </div>
        <div class="text-center mt-3">
            <p>Forgot Password? <a href="reset-password.php">Click Here</a></p>
        </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?PHP
    if(isset($_POST['log']))
    {
        $email=$_POST['email'];
        $pass=$_POST['password'];
        $sql="SELECT * FROM `user` WHERE `Email`='$email'";
        $result=mysqli_query($con,$sql);
        $num=mysqli_num_rows($result);
        if($num>0)
        {
            $row=mysqli_fetch_assoc($result);
            $userid=$row['UserID'];
            $name=$row['Name'];
            $businessName=$row['BuisnessName'];
            $businessType=$row['BuisnessType'];
            $gstNumber=$row['GSTIN'];
            $category=$row['Category'];
            $phoneNumber=$row['PhoneNumber'];
            $hpass=$row['Password'];
            if(password_verify($pass, $hpass))
            {
                $_SESSION['userid']=$userid;
                $_SESSION['name']=$name;
                $_SESSION['email']=$email;
                $_SESSION['businessName']=$businessName;
                $_SESSION['businessType']=$businessType;
                $_SESSION['gstNumber']=$gstNumber;
                $_SESSION['category']=$category;
                $_SESSION['phoneNumber']=$phoneNumber;
                echo "<script>window.open('dashboard.php','_self')</script>";
            }
            else
            {
                echo "<div class='alert alert-danger' role='alert'>
  Invalid Password!
</div>";
            }
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
</body>
</html>