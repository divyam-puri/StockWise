<?PHP
  session_start();
  if(!isset($_SESSION['userid']))
  {
    echo "<script>window.open('login.php','_self')</script>";
  }
  include 'connection.php';
  include 'functions.php';
  $userid=$_SESSION['userid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StockWise: Add Product</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image" href="box-seam.svg">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      font-size: 0.9rem;
    }
    
    .wrapper {
      display: flex;
      width: 100%;
      align-items: stretch;
    }
    
    #sidebar {
      min-width: 250px;
      max-width: 250px;
      background: #0d6efd;
      color: #fff;
      transition: all 0.3s;
      height: 100vh;
      position: fixed;
      z-index: 1000;
      left: 0;
    }
    
    #sidebar.collapsed {
      margin-left: -250px;
    }
    
    .sidebar-content {
      height: calc(100vh - 60px);
      overflow-y: auto;
      margin-top: 60px;
    }
    
    #content {
      width: 100%;
      padding: 15px;
      min-height: 100vh;
      margin-left: 220px;
      transition: all 0.3s;
      background-color: #f8f9fa;
    }
    
    #content.expanded {
      margin-left: 0;
    }
    
    .sidebar-header {
      padding: 15px;
      background: #0d6efd;
      position: fixed;
      top: 0;
      width: 250px;
      z-index: 1001;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .sidebar-header h3 {
      margin: 0;
      font-weight: 600;
      font-size: 1.4rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      display: flex;
      align-items: center;
    }

    .sidebar-header .hamburger-btn {
      color: white;
      background: transparent;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      padding: 5px;
      margin-left: 10px;
      border-radius: 3px;
    }

    .sidebar-header .hamburger-btn:hover {
      background: rgba(255,255,255,0.1);
    }
    
    .nav-item {
      width: 100%;
    }
    
    .nav-link {
      padding: 8px 15px;
      color: rgba(255, 255, 255, 0.9) !important;
      border-left: 4px solid transparent;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
    }

    .nav-link i {
      margin-right: 10px;
      width: 16px;
      font-size: 0.95rem;
      text-align: center;
      flex-shrink: 0;
    }

    .nav-link span {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      display: inline-block !important;
    }

    .nav-link:hover {
      background: #0b5ed7;
      border-left-color: #ffffff;
      color: #ffffff !important;
    }
    
    .active {
      background: #0b5ed7;
      border-left-color: #ffffff;
    }

    .nav-item {
      margin-bottom: 2px;
    }

    .logo-cube {
      width: 24px;
      height: 24px;
      margin-right: 10px;
    }
    
    .show-menu-btn {
      position: fixed;
      top: 10px;
      left: 10px;
      background: #0d6efd;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 6px 10px;
      cursor: pointer;
      z-index: 999;
      display: none;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      font-size: 0.85rem;
    }
    
    body.sidebar-collapsed .show-menu-btn {
      display: block;
    }
    
    .dropdown-menu {
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border: 1px solid rgba(0,0,0,0.08);
      padding: 6px 0;
      font-size: 0.85rem;
    }
    
    .dropdown-item {
      padding: 6px 15px;
      color: #333;
      transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
      background-color: #f8f9fa;
    }
    
    .dropdown-item i {
      margin-right: 8px;
      width: 14px;
      text-align: center;
      color: #6c757d;
    }
    
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .stats-card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .stats-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .stats-icon {
      width: 48px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
    }
    
    .bg-light-primary {
      background-color: rgba(13, 110, 253, 0.15);
      color: #0d6efd;
    }
    
    .bg-light-success {
      background-color: rgba(25, 135, 84, 0.15);
      color: #198754;
    }
    
    .bg-light-warning {
      background-color: rgba(255, 193, 7, 0.15);
      color: #ffc107;
    }
    
    .bg-light-danger {
      background-color: rgba(220, 53, 69, 0.15);
      color: #dc3545;
    }
    
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }
    
    @media (max-width: 768px) {
      #sidebar {
        min-width: 160px;
        max-width: 160px;
      }
      
      .sidebar-header {
        width: 160px;
      }
      
      .nav-link i {
        margin-right: 6px;
        font-size: 0.85em;
        width: auto;
      }
      
      #sidebar .nav-link span {
        display: inline-block !important;
        font-size: 0.85rem;
      }
      
      #content {
        margin-left: 180px;
      }
      
      #content.expanded {
        margin-left: 0;
      }
      
      .sidebar-header h3 {
        font-size: 1.1rem;
      }
      
      .sidebar-header h3 span {
        display: inline !important;
      }
      
      .logo-cube {
        width: 18px;
        height: 18px;
      }
    
    /* Page title styling */
    .page-title {
      font-weight: 600;
      color: #0d6efd;
      margin-bottom: 1.5rem;
      font-size: 1.4rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #e9ecef;
    }
    
    /* Card styling */
    .card {
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 20px;
      border: none;
      overflow: hidden;
    }
    
    .card-header {
      background-color: #f8f9fa;
      border-bottom: 1px solid rgba(0,0,0,0.05);
      padding: 15px 20px;
    }
    
    .card-header h5 {
      margin: 0;
      font-weight: 600;
      color: #0d6efd;
      font-size: 1.1rem;
    }
    
    .card-body {
      padding: 25px 20px;
      background-color: white;
    }
    
    /* Form control styling */
    .form-label {
      font-weight: 500;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      color: #495057;
    }
    
    .form-control, .input-group-text {
      padding: 0.5rem 0.75rem;
      font-size: 0.9rem;
      border-radius: 6px;
      border: 1px solid #ced4da;
      transition: all 0.2s;
    }
    
    .form-control:focus {
      border-color: rgba(13, 110, 253, 0.4);
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .input-group-text {
      background-color: #f8f9fa;
    }
    
    /* Button styling */
    .btn {
      font-size: 0.9rem;
      padding: 0.5rem 1.5rem;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s;
    }
    
    .btn-primary {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }
    
    .btn-primary:hover {
      background-color: #0b5ed7;
      border-color: #0a58ca;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-light {
      background-color: #f8f9fa;
      border-color: #f8f9fa;
      color: #495057;
    }
    
    .btn-light:hover {
      background-color: #e9ecef;
      border-color: #dae0e5;
    }
    
    /* Form group spacing */
    .form-group {
      margin-bottom: 1.5rem;
    }
    
    /* Required field indicator */
    .required-indicator {
      color: #dc3545;
      margin-left: 2px;
    }
    
    /* Input animation */
    .animated-input {
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .animated-input:focus {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(13, 110, 253, 0.15);
    }
    
    /* Modified for mobile view */
    @media (max-width: 576px) {
      #sidebar {
        min-width: 160px;
        max-width: 160px;
      }
      
      .sidebar-header {
        width: 160px;
      }
      
      #content {
        margin-left: 160px;
      }
      
      #content.expanded {
        margin-left: 0;
      }
      
      .nav-link i {
        font-size: 0.85em;
        margin-right: 6px;
      }
      
      .nav-link span {
        font-size: 0.8rem;
      }
      
      .sidebar-header h3 {
        font-size: 1rem;
      }
      
      .sidebar-header h3 span {
        display: inline !important;
      }
      
      .logo-cube {
        width: 18px;
        height: 18px;
      }
      
      .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- Show Menu Button (visible only when sidebar is hidden) -->
  <button id="showMenuBtn" class="show-menu-btn">
    <i class="fas fa-bars"></i> Menu
  </button>

  <div class="wrapper">
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3>
          <svg class="logo-cube" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 16.5C21 16.88 20.79 17.21 20.47 17.38L12.57 21.82C12.41 21.94 12.21 22 12 22C11.79 22 11.59 21.94 11.43 21.82L3.53 17.38C3.21 17.21 3 16.88 3 16.5V7.5C3 7.12 3.21 6.79 3.53 6.62L11.43 2.18C11.59 2.06 11.79 2 12 2C12.21 2 12.41 2.06 12.57 2.18L20.47 6.62C20.79 6.79 21 7.12 21 7.5V16.5ZM12 4.15L5.04 7.5L12 10.85L18.96 7.5L12 4.15ZM5 15.91L11 19.29V12.58L5 9.21V15.91ZM13 19.29L19 15.91V9.21L13 12.58V19.29Z"/>
          </svg>
          <span>StockWise</span>
        </h3>
        <button id="sidebarCollapseBtn" class="hamburger-btn">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="sidebar-content" style="font-size: 111.5%;">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="fas fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="stock.php" class="nav-link">
              <i class="fas fa-boxes"></i>
              <span>Stock</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="sales.php" class="nav-link">
              <i class="fas fa-shopping-cart"></i>
              <span>Sales</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="purchase.php" class="nav-link">
              <i class="fas fa-file-invoice-dollar"></i>
              <span>Purchase</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="profit.php" class="nav-link">
              <i class="fas fa-chart-line"></i>
              <span>Profit</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="manage_vendors.php" class="nav-link">
              <i class="fas fa-handshake"></i>
              <span>Vendors</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="products.php" class="nav-link active">
              <i class="fas fa-box-open"></i>
              <span>Products</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle"></i>
              <span>Profile</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="viewProfile.php"><i class="fas fa-user"></i> View Profile</a></li>
              <li><a class="dropdown-item" href="edit_profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
              <li><a class="dropdown-item" href="change_password.php"><i class="fas fa-key"></i> Reset Password</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    
    <!-- Page Content -->
    <div id="content">
      <div class="container-fluid">
        <h2 class="page-title">
          <i class="bi bi-box-seam me-2"></i>
          Add New Product
        </h2>
        
        <div class="card">
          <div class="card-header">
            <h5><i class="bi bi-plus-circle me-2"></i>Product Details</h5>
          </div>
          <div class="card-body">
            <form id="addProductForm" class="pb-3" method="POST" action="<?php $_SERVER
   ['PHP_SELF']; ?>">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="productName" class="form-label">Product Name<span class="required-indicator">*</span></label>
                  <input type="text" class="form-control animated-input" id="productName" placeholder="Enter product name" required name="name">
                </div>
                <div class="col-md-6 form-group">
                  <label for="productSKU" class="form-label">SKU<span class="required-indicator">*</span></label>
                  <input type="text" class="form-control animated-input" id="productSKU" placeholder="Enter product SKU" required name="sku">
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="sellingPrice" class="form-label">Selling Price<span class="required-indicator">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-currency-rupee"></i></span>
                    <input type="number" class="form-control animated-input" id="sellingPrice" placeholder="0.00" step="0.01" min="0" required name="sp">
                  </div>
                </div>
                <div class="col-md-6 form-group">
                  <label for="purchasePrice" class="form-label">Purchase Price<span class="required-indicator">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-currency-rupee"></i></span>
                    <input type="number" class="form-control animated-input" id="purchasePrice" placeholder="0.00" step="0.01" min="0" required name="pp">
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="productInventory" class="form-label">Inventory<span class="required-indicator">*</span></label>
                  <input type="number" class="form-control animated-input" id="productInventory" placeholder="0" min="0" required name="inventory">
                </div>
                <div class="col-md-6 form-group">
                  <label for="productLocation" class="form-label">Location</label>
                  <input type="text" class="form-control animated-input" id="productLocation" placeholder="Enter storage location" name="loc">
                </div>
              </div>
              
              <div class="form-group">
                <label for="productDescription" class="form-label">Description</label>
                <textarea class="form-control animated-input" id="productDescription" rows="3" placeholder="Enter product description" name="desc"></textarea>
              </div>
              
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-light me-3" onclick="window.history.back();">
                  <i class="bi bi-x-circle me-1"></i>Cancel
                </button>
                <button type="submit" class="btn btn-primary" name="add">
                  <i class="bi bi-plus-circle me-1"></i>Add Item
                </button>
              </div>
            </form>
<?PHP
  if(isset($_POST['add']))
  {
    $name=$_POST['name'];
    $sku=$_POST['sku'];
    $sp=$_POST['sp'];
    $pp=$_POST['pp'];
    $inventory=$_POST['inventory'];
    $loc=$_POST['loc'];
    $desc=$_POST['desc'];
    if($inventory>0)
    {
    if($sp>$pp)
    {
      $sql="INSERT INTO `product` (`Name`,`SKU`,`SP`,`PP`,`Inventory`,`Location`,`Description`,`UserID`) VALUES ('$name','$sku','$sp','$pp','$inventory','$loc','$desc','$userid')";
      $result=mysqli_query($con,$sql);
      echo "<div class='alert alert-success' role='alert'>
  Product Added Successfully!
</div>";
    }
    else
    {
      echo "<div class='alert alert-danger' role='alert'>
  Selling Price Should be Greater than the Purchase Price!
</div>";
    }}
    else
    {
      echo "<div class='alert alert-danger' role='alert'>
  inventory Should be Greater than 0!
</div>";
    }
  }
?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
      const showMenuBtn = document.getElementById('showMenuBtn');
      const sidebarHeader = document.querySelector('.sidebar-header');
      const addProductForm = document.getElementById('addProductForm');
      const formInputs = document.querySelectorAll('.animated-input');
      
      function collapseSidebar() {
        sidebar.classList.add('collapsed');
        content.classList.add('expanded');
        document.body.classList.add('sidebar-collapsed');
      }
      
      function expandSidebar() {
        sidebar.classList.remove('collapsed');
        content.classList.remove('expanded');
        document.body.classList.remove('sidebar-collapsed');
      }
      
      sidebarCollapseBtn.addEventListener('click', collapseSidebar);
      showMenuBtn.addEventListener('click', expandSidebar);
      
      // Form input animation effects
      formInputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
          this.parentElement.classList.remove('focused');
        });
      });
      
      
      // Force spans to be visible at all times
      const allSpans = document.querySelectorAll('.nav-link span');
      allSpans.forEach(span => {
        span.style.display = 'inline-block';
      });
      
      // Modified layout adjustment to keep text visible
      window.addEventListener('resize', adjustLayout);
      
      function adjustLayout() {
        const isMobile = window.innerWidth <= 768;
        const isVerySmall = window.innerWidth <= 576;
        
        // Make sure spans are visible
        document.querySelectorAll('.nav-link span').forEach(span => {
          span.style.display = 'inline-block';
        });
        
        // Make sure header text is visible
        const headerSpan = document.querySelector('.sidebar-header h3 span');
        if (headerSpan) {
          headerSpan.style.display = 'inline';
        }
        
        if (isVerySmall) {
          sidebar.style.minWidth = '160px';
          sidebar.style.maxWidth = '160px';
          if (!sidebar.classList.contains('collapsed')) {
            content.style.marginLeft = '160px';
          }
          if (sidebarHeader) sidebarHeader.style.width = '160px';
        } else if (isMobile) {
          sidebar.style.minWidth = '180px';
          sidebar.style.maxWidth = '180px';
          if (!sidebar.classList.contains('collapsed')) {
            content.style.marginLeft = '180px';
          }
          if (sidebarHeader) sidebarHeader.style.width = '180px';
        } else {
          sidebar.style.minWidth = '250px';
          sidebar.style.maxWidth = '250px';
          if (!sidebar.classList.contains('collapsed')) {
            content.style.marginLeft = '250px';
          }
          if (sidebarHeader) sidebarHeader.style.width = '250px';
        }

        if (sidebar.classList.contains('collapsed')) {
          content.style.marginLeft = '0';
        }
      }
      
      // Run layout adjustment initially
      adjustLayout();
    });
  </script>
</body>
</html>