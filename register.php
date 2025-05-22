<?PHP
    session_start();
    include 'connection.php';
    include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockWise: Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="front.css">
    <link rel="icon" type="image" href="box-seam.svg">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Sign Up</h2>

        <form id="registrationForm" method="POST" action="<?php $_SERVER
   ['PHP_SELF']; ?>">
            <div class="form-group mb-3">
                <label for="customerName">Customer Name: <span class="text-danger">*</span></label>
                <input type="text" id="customerName" name="customerName" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="businessName">Business Name: <span class="text-danger">*</span></label>
                <input type="text" id="businessName" name="businessName" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="businessType">Business Type: <span class="text-danger">*</span></label>
                <select id="businessType" name="businessType" class="form-control" required>
                    <option value="">Select Business Type</option>
                    <option value="pvt_llp">Private LLP</option>
                    <option value="sole_proprietorship">Sole Proprietorship</option>
                    <option value="partnership">Partnership</option>
                    <option value="corporation">Corporation</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="gstNumber">GST Number:</label>
                <input type="text" id="gstNumber" name="gstNumber" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="category">Category: <span class="text-danger">*</span></label>
                <select id="category" name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothes">Clothes</option>
                    <option value="stationary">Stationary</option>
                    <option value="others">Others</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email ID: <span class="text-danger">*</span></label>
                <div class="email-otp">
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="password">Password: <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" class="form-control" required 
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                       title="Must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                <div id="password-requirements" class="password-requirements mt-2">
                    <small>Password must contain the following:</small>
                    <small id="letter" class="invalid">A <b>lowercase</b> letter</small>
                    <small id="capital" class="invalid">A <b>capital (uppercase)</b> letter</small>
                    <small id="number" class="invalid">A <b>number</b></small>
                    <small id="length" class="invalid">Minimum <b>8 characters</b></small>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="confirmPassword">Confirm Password: <span class="text-danger">*</span></label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                <small id="password-match" class="invalid d-none">Passwords do not match</small>
            </div>

            <div class="form-group mb-3">
                <label for="phoneNumber">Phone Number: <span class="text-danger">*</span> 📱</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" required>
            </div>

            <a href="otp.php"><button type="submit" class="btn btn-success w-100" name="verify">Send OTP!</button></a>
        </form>
        
        <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php" id="goToLogin">Login</a></p>
        </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="first.js"></script> -->
</body>
<?php
    if(isset($_POST['verify']))
    {
        $name=$_POST['customerName'];
        $businessName=$_POST['businessName'];
        $businessType=$_POST['businessType'];
        $gstNumber=$_POST['gstNumber'];
        $category=$_POST['category'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $confirmPassword=$_POST['confirmPassword'];
        $phoneNumber=$_POST['phoneNumber'];
        $_SESSION['email']=$email;
        $_SESSION['name']=$name;
        $_SESSION['businessName']=$businessName;
        $_SESSION['businessType']=$businessType;
        $_SESSION['gstNumber']=$gstNumber;
        $_SESSION['category']=$category;
        $_SESSION['phoneNumber']=$phoneNumber;
        
        if($password==$confirmPassword)
        {
            $_SESSION['password']=$password;
            $sql="SELECT * FROM `user` WHERE `Email`='$email'";
            $result=mysqli_query($con,$sql);
            $num=mysqli_num_rows($result);
            if($num>0)
            {
                echo "<div class='alert alert-danger' role='alert'>
  Email ID already exist, try with another Email ID!
</div>";
            }
            else{
            $token=rand(1000,9999);
            $_SESSION['token']=$token;
            sendemail_verify($name,$email,$token);
            echo "<script>window.open('otp.php','_self')</script>";
        }}
        else
        {
            echo "<div class='alert alert-danger' role='alert'>
  Password and Confirm Password should be Same!
</div>";
        }
    }
    echo "</div>";
?>
</html>