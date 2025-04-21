<?PHP
  session_start();
  if(!isset($_SESSION['userid']))
  {
    echo "<script>window.open('login.php','_self')</script>";
    exit;
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
  <title>StockWise: Products</title>
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
    
    /* Header with title and add button */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    /* Modified for mobile view */
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
    /* For very small mobile devices */
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
        <!-- Page Header with Title and Add Button in same line -->
        <div class="page-header">
          <h2 class="page-title">
            <i class="bi bi-box-seam me-2"></i>
            Products
          </h2>
          
          <a href="add_item.php" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Add New Product
          </a>
        </div>
        
        <!-- Products Table -->
        <div class="card">
          <div class="card-header">
            <h5><i class="bi bi-table me-2"></i>Product List</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Inventory</th>
                    <th>Cost Price</th>
                    <th>Selling Price</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    // Fetch all products
                    $sql = "SELECT * FROM `product` WHERE `UserID`='$userid'";
                    $result = mysqli_query($con, $sql);
                    
                    if(mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row['ProductID'] . "</td>
                                <td>" . htmlspecialchars($row['Name']) . "</td>
                                <td>" . htmlspecialchars($row['SKU']) . "</td>
                                <td>" . htmlspecialchars($row['Category']) . "</td>
                                <td>" . $row['Inventory'] . "</td>
                                <td>₹" . number_format($row['CP'], 2) . "</td>
                                <td>₹" . number_format($row['SP'], 2) . "</td>
                                <td>
                                  <a href='manage_products.php?id=" . $row['ProductID'] . "' class='btn btn-sm btn-outline-primary'>
                                    <i class='bi bi-pencil'></i>
                                  </a>
                                  <a href='delete.php?product=" . $row['ProductID'] . "' class='btn btn-sm btn-outline-danger ms-1' onclick='return confirm(\"Are you sure you want to delete this product?\");'>
                                    <i class='bi bi-trash'></i>
                                  </a>
                                </td>
                              </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='8' class='text-center'>No products found.</td></tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
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