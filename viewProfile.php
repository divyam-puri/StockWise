<?PHP
    session_start();
    if(!isset($_SESSION['userid']))
    {
        echo "<script>window.open('login.php','_self')</script>";
    }
    include 'connection.php';
    include 'functions.php';
    $userid=$_SESSION['userid'];
    $sql="Select * FROM `user` WHERE `UserID`='$userid'";
    $result=mysqli_query($con,$sql);
    $num=mysqli_num_rows($result);
    if($num>0)
    {
        $row=mysqli_fetch_assoc($result);
        $name=$row['Name'];
        $email=$row['Email'];
        $businessName=$row['BuisnessName'];
        $businessType=$row['BuisnessType'];            
        $gstNumber=$row['GSTIN'];
        $category=$row['Category'];
        $phoneNumber=$row['PhoneNumber'];
        $hpass=$row['Password'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockWise: View Profile</title>
    <!-- Adding Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Adding Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image" href="box-seam.svg">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            height: 100vh;
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
        
        /* Sidebar collapsed state */
        #sidebar.collapsed {
            margin-left: -250px;
        }
        
        /* Sidebar scroll container */
        .sidebar-content {
            height: calc(100vh - 60px);
            overflow-y: auto;
            margin-top: 60px;  /* Match header height */
        }
        
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            margin-left: 250px;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Content expanded state when sidebar is collapsed */
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
        
        /* Hamburger button inside header */
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
            display: inline-block !important; /* Force display of spans */
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
        
        /* Create spacing between nav items */
        .nav-item {
            margin-bottom: 2px;
        }
        
        /* Logo styling */
        .logo-cube {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        
        /* Show menu button when sidebar is collapsed */
        .show-menu-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            z-index: 999;
            display: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        /* Show button when sidebar is collapsed */
        body.sidebar-collapsed .show-menu-btn {
            display: block;
        }
        
        /* Profile dropdown styling */
        .dropdown-menu {
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.08);
            padding: 8px 0;
        }
        
        .dropdown-item {
            padding: 8px 20px;
            color: #333;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .dropdown-item i {
            margin-right: 10px;
            width: 16px;
            text-align: center;
            color: #6c757d;
        }
        
        /* Profile form container styling */
        .profile-container {
            width: 100%;
            max-width: 500px;
            padding: 20px 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: auto;
            margin: 20px 0;
            overflow-y: auto;
            max-height: 85vh;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 12px;
        }
        
        .actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }
        
        /* Modified for mobile view to keep text visible */
        @media (max-width: 768px) {
            #sidebar {
                min-width: 180px; /* Wider sidebar to fit text */
                max-width: 180px;
            }
            
            .sidebar-header {
                width: 180px;
            }
            
            .nav-link i {
                margin-right: 8px;
                font-size: 0.9em;
                width: auto;
            }
            
            #sidebar .nav-link span {
                display: inline-block !important; /* Force display of spans */
                font-size: 0.9rem; /* Slightly smaller font */
            }
            
            #content {
                margin-left: 180px;
            }
            
            #content.expanded {
                margin-left: 0;
            }
            
            .sidebar-header h3 {
                font-size: 1.2rem;
            }
            
            /* Show the text in the header */
            .sidebar-header h3 span {
                display: inline !important;
            }
            
            .logo-cube {
                width: 20px;
                height: 20px;
            }
        }

        /* For very small mobile devices - still keep text visible */
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
            
            /* Make sure header text is still visible */
            .sidebar-header h3 span {
                display: inline !important;
            }
            
            .logo-cube {
                width: 18px;
                height: 18px;
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
    <!-- Sidebar -->
    <nav id="sidebar">
      <!-- Fixed Header -->
      <div class="sidebar-header">
        <h3>
          <!-- Cube logo -->
          <svg class="logo-cube" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 16.5C21 16.88 20.79 17.21 20.47 17.38L12.57 21.82C12.41 21.94 12.21 22 12 22C11.79 22 11.59 21.94 11.43 21.82L3.53 17.38C3.21 17.21 3 16.88 3 16.5V7.5C3 7.12 3.21 6.79 3.53 6.62L11.43 2.18C11.59 2.06 11.79 2 12 2C12.21 2 12.41 2.06 12.57 2.18L20.47 6.62C20.79 6.79 21 7.12 21 7.5V16.5ZM12 4.15L5.04 7.5L12 10.85L18.96 7.5L12 4.15ZM5 15.91L11 19.29V12.58L5 9.21V15.91ZM13 19.29L19 15.91V9.21L13 12.58V19.29Z"/>
          </svg>
          <span>StockWise</span>
        </h3>
        <!-- Close button in header -->
        <button id="sidebarCollapseBtn" class="hamburger-btn">
          <i class="fas fa-times"></i>
        </button>
      </div>
      
      <!-- Scrollable Content -->
      <div class="sidebar-content">
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
            <a href="products.php" class="nav-link">
              <i class="fas fa-box-open"></i>
              <span>Products</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle active" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle"></i>
              <span>Profile</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="viewProfile.php"><i class="fas fa-user"></i> View Profile</a></li>
              <li><a class="dropdown-item" href="edit_profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
              <li><a class="dropdown-item" href="change_password.php"><i class="fas fa-key"></i> Change Password</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    
    <!-- Page Content -->
    <div id="content">
      <div class="profile-container">
        <h2>View Profile</h2>
        
        <form id="editProfileForm" class="pb-3" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        
            <div class="form-group">
                <label for="customerName">Customer Name:</label>
                <input type="text" id="customerName" name="customerName" class="form-control" required value="<?PHP echo $name; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="businessName">Business Name:</label>
                <input type="text" id="businessName" name="businessName" class="form-control" required value="<?PHP echo $businessName; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="businessType">Business Type:</label>
                <select id="businessType" name="businessType" class="form-control" required disabled>
                    <option value="<?PHP echo $businessType; ?>"><?PHP echo $businessType; ?></option>
                    <option value="pvt_llp">Private LLP</option>
                    <option value="sole_proprietorship">Sole Proprietorship</option>
                    <option value="partnership">Partnership</option>
                    <option value="corporation">Corporation</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" class="form-control" required disabled>
                    <option value="<?PHP echo $category; ?>"><?PHP echo $category; ?></option>
                    <option value="electronics">Electronics</option>
                    <option value="clothes">Clothes</option>
                    <option value="stationary">Stationary</option>
                    <option value="others">Others</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="email" id="email" name="email" class="form-control" required value="<?PHP echo $email; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" required value="<?PHP echo $phoneNumber; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="gstNumber">GST Number:</label>
                <input type="text" id="gstNumber" name="gstNumber" class="form-control" value="<?PHP echo $gstNumber; ?>" disabled>
            </div>

            <div class="actions">
                <button type="button" class="cancel-btn btn btn-secondary" onclick="window.history.back();">Cancel</button>
                <button type="submit" class="btn btn-success" name="save">Edit Profile</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Get all necessary elements
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
      const showMenuBtn = document.getElementById('showMenuBtn');
      const sidebarHeader = document.querySelector('.sidebar-header');
      
      // Function to collapse sidebar
      function collapseSidebar() {
        sidebar.classList.add('collapsed');
        content.classList.add('expanded');
        document.body.classList.add('sidebar-collapsed');
      }
      
      // Function to expand sidebar
      function expandSidebar() {
        sidebar.classList.remove('collapsed');
        content.classList.remove('expanded');
        document.body.classList.remove('sidebar-collapsed');
      }
      
      // Toggle sidebar visibility with X button
      sidebarCollapseBtn.addEventListener('click', function() {
        collapseSidebar();
      });
      
      // Show sidebar with menu button
      showMenuBtn.addEventListener('click', function() {
        expandSidebar();
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
        
        // Adjust sidebar width based on screen size
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
        
        // Set content margin to 0 when sidebar is collapsed
        if (sidebar.classList.contains('collapsed')) {
          content.style.marginLeft = '0';
        }
      }
      
      // Run layout adjustment initially
      adjustLayout();
    });
  </script>
  
  <?PHP
    if(isset($_POST['save']))
    {
        echo "<script>window.open('edit_profile.php','_self')</script>";
    }
  ?>
</body>
</html>