<?PHP
  session_start();
    if(!isset($_SESSION['userid']))
    {
        echo "<script>window.open('login.php','_self')</script>";
    }
    include 'connection.php';
    include 'functions.php';
    $userid=$_SESSION['userid'];
    $sql="SELECT * FROM `product` WHERE `UserID`='$userid'";
    $result=mysqli_query($con,$sql);
    $rows=mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StockWise</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image" href="box-seam.svg">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #ffffff;
      overflow-x: hidden;
      margin: 0;
      padding: 0;
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
      padding: 20px;
      min-height: 100vh;
      margin-left: 250px;
      transition: all 0.3s;
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
      margin-bottom: 2px;
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
    
    .logo-cube {
      width: 24px;
      height: 24px;
      margin-right: 10px;
    }
    
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
    
    body.sidebar-collapsed .show-menu-btn {
      display: block;
    }
    
    /* Enhanced Stock Table Styles */
    .stock-container {
      padding: 20px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .stock-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-top: 20px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 1px 15px rgba(0,0,0,0.1);
    }

    .stock-table th {
      background: #0d6efd;
      color: white;
      padding: 12px 15px;
      font-weight: 600;
    }

    .stock-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #f0f0f0;
    }

    .stock-table tr:last-child td {
      border-bottom: none;
    }

    .stock-table tr:hover {
      background-color: #f8faff;
    }

    .action-buttons {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
    }

    .btn-action {
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 0.85rem;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s ease;
      border: none;
    }

    .btn-edit {
      background: #e8f4ff;
      color: #0d6efd;
    }

    .btn-edit:hover {
      background: #d6e8ff;
      transform: translateY(-1px);
    }

    .btn-delete {
      background: #feeceb;
      color: #dc3545;
    }

    .btn-delete:hover {
      background: #fdd9d7;
      transform: translateY(-1px);
    }

    .status-badge {
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: 500;
    }

    .status-in-stock {
      background: #e8f5e9;
      color: #2e7d32;
    }

    .status-low-stock {
      background: #fff3e0;
      color: #ef6c00;
    }

    @media (max-width: 768px) {
      #sidebar {
        min-width: 180px;
        max-width: 180px;
      }
      
      .sidebar-header {
        width: 180px;
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
    }

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
    }
  </style>
</head>
<body>
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
      
      <div class="sidebar-content">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="fas fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="stock.php" class="nav-link active">
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
    
    <div id="content">
      <div class="stock-container">
        <h2>Inventory Overview</h2>
        <?PHP
          if($rows>0)
          {
        ?>
        <table class="stock-table">
          <thead>
            <tr>
              <th>Item ID</th>
              <th>Item Name</th>
              <th>SKU</th>
              <th>Quantity</th>
              <th>Location</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?PHP
              while($row=mysqli_fetch_assoc($result))
              {
                echo "
            <tr>
              <td>".$row['ProductID']."</td>
              <td>".$row['Name']."</td>
              <td>".$row['SKU']."</td>
              <td>".$row['Inventory']."</td>
              <td>".$row['Location']."</td>
              <td>
                <div class='action-buttons'>
                  <a href='manage_products.php?id=".$row['ProductID']."'><button class='btn-action btn-edit'>
                    <i class='fas fa-edit'></i>
                    Edit
                  </button></a>
                  <a href='delete.php?id=".$row['ProductID']."'><button class='btn-action btn-delete'>
                    <i class='fas fa-trash-alt'></i>
                    Delete
                  </button></a>
                </div>
              </td>
            </tr>
          ";
      }
      echo "</tbody>
        </table>";}
          else
          {
            echo "<div class='alert alert-danger' role='alert'>
  Stock Not Available!
</div>";
          }
        ?>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
      const showMenuBtn = document.getElementById('showMenuBtn');

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

      // document.querySelectorAll('.btn-delete').forEach(button => {
      //   button.addEventListener('click', function(e) {
      //     const row = e.target.closest('tr');
      //     if (confirm('Are you sure you want to delete this item?')) {
      //       row.style.transform = 'translateX(100%)';
      //       row.style.opacity = '0';
      //       setTimeout(() => row.remove(), 300);
      //     }
      //   });
      // });

      // document.querySelectorAll('.btn-edit').forEach(button => {
      //   button.addEventListener('click', function(e) {
      //     const row = e.target.closest('tr');
      //     alert('Edit functionality coming soon!');
      //   });
      // });

      window.addEventListener('resize', adjustLayout);
      adjustLayout();

      function adjustLayout() {
        const isMobile = window.innerWidth <= 768;
        const isVerySmall = window.innerWidth <= 576;

        if (isVerySmall) {
          sidebar.style.minWidth = '160px';
          sidebar.style.maxWidth = '160px';
          if (!sidebar.classList.contains('collapsed')) {
            content.style.marginLeft = '160px';
          }
        } else if (isMobile) {
          sidebar.style.minWidth = '180px';
          sidebar.style.maxWidth = '180px';
          if (!sidebar.classList.contains('collapsed')) {
            content.style.marginLeft = '180px';
          }
        } else {
          sidebar.style.minWidth = '250px';
          sidebar.style.maxWidth = '250px';
          if (!sidebar.classList.contains('collapsed')) {
            content.style.marginLeft = '250px';
          }
        }

        if (sidebar.classList.contains('collapsed')) {
          content.style.marginLeft = '0';
        }
      }
    });
  </script>
</body>
</html>