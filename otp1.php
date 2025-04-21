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
    <title>StockWise: OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="front.css">
    <link rel="icon" type="image" href="box-seam.svg">
</head>
<body style="background: linear-gradient(to right, #6a11cb, #2575fc); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: Arial, sans-serif;">
    <div style="background: #fff; padding: 30px 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); max-width: 400px; width: 90%; text-align: center;">
        <h2 style="margin-bottom: 20px; font-size: 24px;">Enter OTP</h2>
        <form method="POST" action="<?php $_SERVER
   ['PHP_SELF']; ?>" class="pb-3">
        <input type="text" placeholder="Enter the OTP sent to your E-Mail ID" style="width: calc(100% - 24px); padding: 12px; font-size: 16px; border: 1px solid #ced4da; border-radius: 10px; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;" required name="otp">
        <button type ="submit" style="background-color: #28a745; color: white; border-radius: 10px; padding: 12px; font-size: 16px; width: 100%; border: none; cursor: pointer;" name="register">Register</button>
    </form>
    
<?PHP
    if(isset($_POST['register']))
    {
        if($_POST['otp']==$_SESSION['token'])
        {
            $userid=$_SESSION['userid'];
            $name=$_SESSION['name'];
            $businessName=$_SESSION['businessName'];
            $businessType=$_SESSION['businessType'];
            $gstNumber=$_SESSION['gstNumber'];
            $category=$_SESSION['category'];
            $email=$_SESSION['email'];
            $phoneNumber=$_SESSION['phoneNumber'];
            $hpass=password_hash($password, PASSWORD_DEFAULT);
            $sql="UPDATE `user` SET `Name` = '$name',`BuisnessName`='$businessName',`BuisnessType`='$businessType',`GSTIN`='$gstNumber',`Category`='$category',`Email`='$email',`PhoneNumber`='$phoneNumber' WHERE `UserID` = '$userid'";
            $result=mysqli_query($con,$sql);
            session_destroy();
            echo "<script>alert('Account Updated Successfully, Kindly LogIn!')</script>";
            echo "<script>window.open('login.php','_self')</script>";
        }
        else
        {
            echo "<div class='alert alert-danger' role='alert'>
  Invalid OTP, Please Try Again!
</div>";
        }
    }
    echo "</div>";
?>
</body>
</html>
