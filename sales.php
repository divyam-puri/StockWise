<?PHP
  session_start();
  if(!isset($_SESSION['userid']))
  {
    echo "<script>window.open('login.php','_self')</script>";
  }
  include 'connection.php';
  include 'functions.php';
  $userid=$_SESSION['userid'];
  $sql="SELECT * FROM `order` WHERE `OrderType`='sales' and `UserID`='$userid'";
  $result=mysqli_query($con,$sql);
  $rows=mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StockWise: Sales</title>
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

    @media (max-width: 768px) {
      #sidebar {
        min-width: 180px;
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
        display: inline-block !important;
        font-size: 0.9rem;
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

      .sidebar-header h3 span {
        display: inline !important;
      }

      .logo-cube {
        width: 20px;
        height: 20px;
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
    }

    .sales-container {
      padding: 20px;
    }

    .sales-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .sales-table th,
    .sales-table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    .sales-table th {
      background-color: #f2f2f2;
    }

    .sales-table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .sales-table tr:hover {
      background-color: #f0f0f0;
    }

    .add-order-btn {
      margin-bottom: 20px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-body input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .sales-graph {
      margin-bottom: 20px;
      max-width: 100%;
    }

    @media (max-width: 576px) {
      .sales-table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
      }

      .modal-content {
        width: 90%;
        margin: 20% auto;
      }

      .add-order-btn {
        display: block;
        width: 100%;
        margin-bottom: 15px;
      }

      .sales-table .btn {
        font-size: 0.85rem;
        padding: 4px 8px;
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
            <a href="stock.php" class="nav-link">
              <i class="fas fa-boxes"></i>
              <span>Stock</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="sales.php" class="nav-link active">
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
      <div id="page-sales" class="page-section sales-container">
        <h2>Sales</h2>
        <div class="sales-graph">
          <canvas id="salesChart"></canvas>
        </div>
        <h3>Recent Orders</h3>
        <button id="addOrderBtn" class="btn btn-primary add-order-btn">Add New Order</button>
        <div class="table-responsive">
          <?PHP
            if($rows>0)
            {
          ?>
          <table class="sales-table table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?PHP
                while($row=mysqli_fetch_assoc($result))
                {
                  echo "<tr>
                <td>".$row['OrderID']."</td>
                <td>".$row['ProductID']."</td>
                <td>".$row['Name']."</td>
                <td>".$row['Quantity']."</td>
                <td>".$row['BillAmt']."</td>
                <td>
                  <a href='delete.php?order=".$row['OrderID']."'><button class='btn btn-sm btn-danger'>Delete</button></a>
                </td>
              </tr>";
                }
              ?>
            </tbody>
          </table>
          <?PHP
            }
            else
            {
              echo "<div class='alert alert-danger' role='alert'>
  Sales Not Available!
</div>";
            }
          ?>
        </div>
      </div>
      <div id="addOrderModal" class="modal">
        <div class="modal-content">
          <span class="close">×</span>
          <h2>Add New Order</h2>
          <div class="modal-body">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <select class="form-select form-select-lg mb-3" aria-label="Select Product" name="id" required>
                <option selected>Select Product</option>
                <?PHP
                  $sql1="SELECT * FROM `product` WHERE `UserID`='$userid'";
                  $resut1=mysqli_query($con,$sql1);
                  while($row1=mysqli_fetch_assoc($resut1))
                  {
                    echo "<option value=".$row1['ProductID'].">".$row1['Name']." [ID: ".$row1['ProductID']."]</option>";
                  }
                ?>
              </select>
              <input type="number" id="Quantity" placeholder="Quantity" name="qty" required>
              <button class="btn btn-success" type="submit" name="save">Save Order</button>
            </form>
            <?PHP
              if(isset($_POST['save']))
              {
                $product=$_POST['id'];
                $qty=$_POST['qty'];
                $sql1="SELECT * FROM `product` WHERE `ProductID`='$product'";
                $result1=mysqli_query($con,$sql1);
                $row1=mysqli_fetch_assoc($result1);
                $amt=$row1['SP'];
                $name=$row1['Name'];
                $bamt=$amt*$qty;
                $sql="SELECT * FROM `product` WHERE `ProductID`='$product'";
                $result=mysqli_query($con,$sql);
                $row=mysqli_fetch_assoc($result);
                $quantity=$row['Inventory'];
                if($qty<=$quantity)
                {
                  $newqty=$quantity-$qty;
                  $sql="INSERT INTO `order` (`ProductID`,`Name`,`Quantity`,`Amount`,`BillAmt`,`OrderType`,`UserID`) VALUES ('$product','$name','$qty','$amt','$bamt','sales','$userid')";
                  $result=mysqli_query($con,$sql);
                  $sql="UPDATE `product` SET `Inventory`='$newqty' WHERE `ProductID`='$product'";
                  $result=mysqli_query($con,$sql);
                  echo "<script>window.open('sales.php','_self')</script>";
                }
                else
                {
                  echo "<script>alert('Requested Quantity is not in stock')</script>";
                  echo "<script>window.open('sales.php','_self')</script>";
                }
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
      const showMenuBtn = document.getElementById('showMenuBtn');
      const sidebarHeader = document.querySelector('.sidebar-header');

      const addOrderBtn = document.getElementById('addOrderBtn');
      const addOrderModal = document.getElementById('addOrderModal');
      const orderCloseBtn = addOrderModal.querySelector('.close');

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

      const allSpans = document.querySelectorAll('.nav-link span');
      allSpans.forEach(span => {
        span.style.display = 'inline-block';
      });

      window.addEventListener('resize', adjustLayout);

      function adjustLayout() {
        const isMobile = window.innerWidth <= 768;
        const isVerySmall = window.innerWidth <= 576;

        document.querySelectorAll('.nav-link span').forEach(span => {
          span.style.display = 'inline-block';
        });

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

      adjustLayout();

      addOrderBtn.addEventListener('click', function() {
        addOrderModal.style.display = 'block';
      });

      orderCloseBtn.addEventListener('click', function() {
        addOrderModal.style.display = 'none';
      });

      window.addEventListener('click', function(event) {
        if (event.target === addOrderModal) {
          addOrderModal.style.display = 'none';
        }
      });

      const navLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
      navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          const href = this.getAttribute('href');
          // If the href starts with '#', handle in-page section navigation
          if (href.startsWith('#')) {
            e.preventDefault();
            const target = href.substring(1);
            showSection(target);
          }
          // Otherwise, allow default navigation to other pages
        });
      });

      function showSection(sectionId) {
        document.querySelectorAll('.page-section').forEach(section => {
          section.style.display = 'none';
        });
        const targetSection = document.getElementById('page-' + sectionId);
        if (targetSection) {
          targetSection.style.display = 'block';
        }
        document.querySelectorAll('.nav-link').forEach(link => {
          link.classList.remove('active');
        });
        const activeLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);
        if (activeLink) {
          activeLink.classList.add('active');
        }
      }

      // Initialize the active section
      const initialActive = document.querySelector('.nav-link.active');
      if (initialActive && initialActive.getAttribute('href').startsWith('#')) {
        const initialTarget = initialActive.getAttribute('href').substring(1);
        showSection(initialTarget);
      }

      // Generate Chart.js data dynamically with PHP
      const salesData = {
        labels: [
          <?PHP
            $sql="SELECT * FROM `order` WHERE `OrderType`='sales' AND `UserID`='$userid'";
            $result=mysqli_query($con,$sql);
            $labels = [];
            while($row=mysqli_fetch_assoc($result)) {
              $labels[] = "'".$row['OrderID']."'";
            }
            echo implode(',', $labels);
          ?>
        ],
        datasets: [{
          label: 'Sales',
          data: [
            <?PHP
              $sql="SELECT * FROM `order` WHERE `OrderType`='sales' AND `UserID`='$userid'";
              $result=mysqli_query($con,$sql);
              $data = [];
              while($row=mysqli_fetch_assoc($result)) {
                $data[] = $row['BillAmt'];
              }
              echo implode(',', $data);
            ?>
          ],
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      };

      const ctx = document.getElementById('salesChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: salesData,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-order')) {
          const orderId = e.target.getAttribute('data-order-id');
          alert(`Viewing order ${orderId}`);
        }
      });
    });
  </script>
</body>
</html>