<?PHP
	session_start();
	if(!isset($_SESSION['userid']))
  {
    echo "<script>window.open('login.php','_self')</script>";
  }
  include 'connection.php';
  include 'functions.php';
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$sql="DELETE FROM `product` WHERE `ProductID`='$id'";
		$result=mysqli_query($con,$sql);
		echo "<script>window.open('stock.php','_self')</script>";
	}
	if(isset($_GET['vendor']))
	{
		$id=$_GET['vendor'];
		$sql="DELETE FROM `vendor` WHERE `VendorID`='$id'";
		$result=mysqli_query($con,$sql);
		echo "<script>window.open('manage_vendors.php','_self')</script>";
	}
	if(isset($_GET['product']))
	{
		$id=$_GET['product'];
		$sql="DELETE FROM `product` WHERE `ProductID`='$id'";
		$result=mysqli_query($con,$sql);
		echo "<script>window.open('products.php','_self')</script>";
	}
	if(isset($_GET['order']))
	{
		$id=$_GET['order'];
		$sql="DELETE FROM `order` WHERE `OrderID`='$id'";
		$result=mysqli_query($con,$sql);
		echo "<script>window.open('sales.php','_self')</script>";
	}
?>