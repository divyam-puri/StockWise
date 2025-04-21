<?PHP
  session_start();
  if(!isset($_SESSION['userid']))
  {
    echo "<script>window.open('login.php','_self')</script>";
  }
  include 'connection.php';
  include 'functions.php';
  $userid=$_SESSION['userid'];
  $tproduct=0;
  $tstockv=0;
  $lstock=0;
  $out=0;
  $nstock=0;
  $sql="SELECT * FROM `product` WHERE `UserID`='$userid'";
  $result=mysqli_query($con,$sql);
  while($row=mysqli_fetch_assoc($result))
  {
    $tproduct++;
    $pp=$row['PP'];
    $inv=$row['Inventory'];
    $tstockv=$tstockv+($pp*$inv);
    if($row['Inventory']<6)
    {
      $lstock++;
    }
    else
    {
      $nstock++;
    }
    if($row['Inventory']<1)
    {
      $out++;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StockWise: Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image" href="box-seam.svg">
  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
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
      
      .stats-row {
        flex-direction: column;
      }
      
      .chart-row {
        flex-direction: column;
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
            <a href="dashboard.php" class="nav-link active">
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
        <div class="page-header">
          <h2 class="page-title">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
          </h2>
          
          <div class="d-flex align-items-center">
            <span class="text-muted me-3"><i class="bi bi-calendar3 me-1"></i> <?PHP echo date("l");?>, <?PHP echo date("d-m-Y");?></span>
          </div>
        </div>
        
        <!-- Stats Cards Row -->
        <div class="row g-3 mb-4">
          <!-- Total Products Card -->
          <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card stats-card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="stats-icon bg-light-primary">
                    <i class="bi bi-box-seam"></i>
                  </div>
                </div>
                <h5 class="card-title mb-0">Total Products</h5>
                <p class="text-muted small">All products in inventory</p>
                <h3 class="mt-2 mb-0"><?PHP echo $tproduct;?></h3> <!-- Static value replacing PHP query -->
              </div>
            </div>
          </div>
          
          <!-- Total Inventory Value Card -->
          <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card stats-card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="stats-icon bg-light-success">
                    <i class="bi bi-currency-rupee"></i>
                  </div>
                </div>
                <h5 class="card-title mb-0">Total Stock Value</h5>
                <p class="text-muted small">Current inventory value</p>
                <h3 class="mt-2 mb-0">₹<?PHP echo $tstockv;?></h3> <!-- Static value -->
              </div>
            </div>
          </div>
          
          <!-- Low Stock Items Card -->
          <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card stats-card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="stats-icon bg-light-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                  </div>
                </div>
                <h5 class="card-title mb-0">Low Stock Items</h5>
                <p class="text-muted small">Products below threshold</p>
                <h3 class="mt-2 mb-0"><?PHP echo $lstock;?></h3> <!-- Static value -->
              </div>
            </div>
          </div>
          
          <!-- Out of Stock Card -->
          <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="card stats-card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="stats-icon bg-light-danger">
                    <i class="bi bi-x-circle"></i>
                  </div>
                </div>
                <h5 class="card-title mb-0">Out of Stock</h5>
                <p class="text-muted small">Products with zero inventory</p>
                <h3 class="mt-2 mb-0"><?PHP echo $out;?></h3> <!-- Static value -->
              </div>
            </div>
          </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row g-3 mb-4">
          <!-- Sales Chart -->
          <div class="col-12 col-lg-4 mb-3">
            <div class="card h-100">
              <div class="card-header bg-white">
                <h5 class="card-title"><i class="bi bi-graph-up me-2"></i>Sales Overview</h5>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="salesChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Inventory Distribution Chart -->
          <div class="col-12 col-lg-4 mb-3">
            <div class="card h-100">
              <div class="card-header bg-white">
                <h5 class="card-title"><i class="bi bi-pie-chart me-2"></i>Inventory Status</h5>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="inventoryChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Profit Chart -->
          <div class="col-12 col-lg-4 mb-3">
            <div class="card h-100">
              <div class="card-header bg-white">
                <h5 class="card-title"><i class="bi bi-bar-chart me-2"></i>Profit Analysis</h5>
              </div>
              <div class="card-body">
                <div class="chart-container">
                  <canvas id="profitChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Recent Inventory Table -->
        <div class="card mb-4">
          <div class="card-header bg-white">
            <h5 class="card-title"><i class="bi bi-table me-2"></i>Recent Inventory Overview</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?PHP
                $sql="SELECT * FROM `product` WHERE `UserID`='$userid'";
                $result=mysqli_query($con,$sql);
                $rows=mysqli_num_rows($result);
                if($rows>0)
                {
              ?>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Selling Price</th>
                    <th>Purchase Price</th>
                    <th>Inventory</th>
                    <th>Location</th>
                    <th>View More</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Static example data replacing PHP loop -->
                  <?PHP
                    while($row=mysqli_fetch_assoc($result))
                    {
                      echo "<tr>
                    <td>".$row['ProductID']."</td>
                    <td>".$row['Name']."</td>
                    <td>".$row['SKU']."</td>
                    <td>₹".$row['SP']."</td>
                    <td>₹".$row['PP']."</td>
                    <td>".$row['Inventory']."</td>
                    <td>".$row['Location']."</td>
                    <td><center><a href='products.php'><button type='button' class='btn btn-outline-info'><i class='bi bi-eye-fill'></i></button></a></center></td>
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
      
      // Initialize Charts
      
      // Sales Chart - Last 6 months
      const months = ['0'<?PHP
        $sql="SELECT * FROM `order` WHERE `UserID`='$userid' and `OrderType`='sales'";
        $result=mysqli_query($con,$sql);
        while($row=mysqli_fetch_assoc($result))
        {
          echo ",'".$row['OrderID']."'";
        }
      ?>];
      const salesData = ['0'<?PHP
        $sql="SELECT * FROM `order` WHERE `UserID`='$userid' and `OrderType`='sales'";
        $result=mysqli_query($con,$sql);
        while($row=mysqli_fetch_assoc($result))
        {
          echo ",'".$row['BillAmt']."'";
        }
      ?>];
      
      const salesCtx = document.getElementById('salesChart').getContext('2d');
      const salesChart = new Chart(salesCtx, {
          type: 'line',
          data: {
              labels: months,
              datasets: [{
                  label: 'Monthly Sales (₹)',
                  data: salesData,
                  backgroundColor: 'rgba(13, 110, 253, 0.1)',
                  borderColor: '#0d6efd',
                  borderWidth: 2,
                  tension: 0.3,
                  fill: true,
                  pointBackgroundColor: '#ffffff',
                  pointBorderColor: '#0d6efd',
                  pointBorderWidth: 2,
                  pointRadius: 4
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: {
                      display: false
                  },
                  tooltip: {
                      callbacks: {
                          label: function(context) {
                              let label = context.dataset.label || '';
                              if (label) {
                                  label += ': ';
                              }
                              label += '₹' + new Intl.NumberFormat('en-IN').format(context.parsed.y);
                              return label;
                          }
                      }
                  }
              },
              scales: {
                  y: {
                      beginAtZero: true,
                      ticks: {
                          callback: function(value) {
                              return '₹' + new Intl.NumberFormat('en-IN').format(value);
                          }
                      }
                  }
              }
          }
      });
      
      // Inventory Status Chart
      const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
      
      // Static data replacing PHP variables
      const normalStock = <?PHP echo $nstock;?>; // Example: 150 - 10 - 5
      const lowStockCount = <?PHP echo $lstock;?>;
      const outOfStockCount = <?PHP echo $out;?>;
      
      const inventoryChart = new Chart(inventoryCtx, {
          type: 'doughnut',
          data: {
              labels: ['Normal Stock', 'Low Stock', 'Out of Stock'],
              datasets: [{
                  data: [normalStock, lowStockCount, outOfStockCount],
                  backgroundColor: [
                      '#198754',
                      '#ffc107',
                      '#dc3545'
                  ],
                  borderWidth: 1,
                  borderColor: '#ffffff'
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: {
                      position: 'bottom',
                      labels: {
                          padding: 20,
                          boxWidth: 12
                      }
                  },
                  tooltip: {
                      callbacks: {
                          label: function(context) {
                              const label = context.label || '';
                              const value = context.parsed || 0;
                              const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                              const percentage = Math.round((value / total) * 100);
                              return `${label}: ${value} (${percentage}%)`;
                          }
                      }
                  }
              },
              cutout: '65%'
          }
      });
      
      // Profit Analysis Chart
      const profitCtx = document.getElementById('profitChart').getContext('2d');
      
      const profitData = {
          labels: ['0'<?PHP
            $sql="SELECT * FROM `order` WHERE `UserID`='$userid' and `OrderType`='sales'";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_assoc($result))
            {
              echo ",'".$row['OrderID']."'";
            }
          ?>],
          revenue: ['0'<?PHP
            $sql="SELECT * FROM `order` WHERE `UserID`='$userid' and `OrderType`='sales'";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_assoc($result))
            {
              echo ",'".$row['BillAmt']."'";
            }
          ?>],
          cost: ['0'<?PHP
            $sql="SELECT * FROM `order` WHERE `UserID`='$userid' and `OrderType`='sales'";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_assoc($result))
            {
              $product=$row['ProductID'];
              $qty=$row['Quantity'];
              $sql1="SELECT * FROM `product` WHERE `ProductID`='$product'";
              $result1=mysqli_query($con,$sql1);
              $row1=mysqli_fetch_assoc($result1);
              $amt=$row1['PP'];
              $bamt=$amt*$qty;
              echo ",'".$bamt."'";
            }
          ?>],
          profit: ['0'<?PHP
            $sql="SELECT * FROM `order` WHERE `UserID`='$userid' and `OrderType`='sales'";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_assoc($result))
            {
              $product=$row['ProductID'];
              $qty=$row['Quantity'];
              $bill=$row['BillAmt'];
              $sql1="SELECT * FROM `product` WHERE `ProductID`='$product'";
              $result1=mysqli_query($con,$sql1);
              $row1=mysqli_fetch_assoc($result1);
              $amt=$row1['PP'];
              $bamt=$amt*$qty;
              $profit=$bill-$bamt;
              echo ",'".$profit."'";
            }
          ?>]
      };
      
      const profitChart = new Chart(profitCtx, {
          type: 'bar',
          data: {
              labels: profitData.labels,
              datasets: [
                  {
                      label: 'Revenue',
                      data: profitData.revenue,
                      backgroundColor: 'rgba(13, 110, 253, 0.7)',
                      order: 3
                  },
                  {
                      label: 'Cost',
                      data: profitData.cost,
                      backgroundColor: 'rgba(220, 53, 69, 0.7)',
                      order: 2
                  },
                  {
                      label: 'Profit',
                      data: profitData.profit,
                      type: 'line',
                      borderColor: 'rgba(25, 135, 84, 1)',
                      backgroundColor: 'rgba(25, 135, 84, 0.2)',
                      borderWidth: 2,
                      fill: true,
                      tension: 0.4,
                      pointBackgroundColor: '#ffffff',
                      pointBorderColor: 'rgba(25, 135, 84, 1)',
                      pointBorderWidth: 2,
                      pointRadius: 4,
                      order: 1
                  }
              ]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              interaction: {
                  intersect: false,
                  mode: 'index'
              },
              plugins: {
                  legend: {
                      position: 'bottom',
                      labels: {
                          padding: 20,
                          boxWidth: 12
                      }
                  },
                  tooltip: {
                      callbacks: {
                          label: function(context) {
                              let label = context.dataset.label || '';
                              if (label) {
                                  label += ': ';
                              }
                              label += '₹' + new Intl.NumberFormat('en-IN').format(context.parsed.y || context.parsed);
                              return label;
                          }
                      }
                  }
              },
              scales: {
                  x: {
                      grid: {
                          display: false
                      }
                  },
                  y: {
                      beginAtZero: true,
                      ticks: {
                          callback: function(value) {
                              return '₹' + new Intl.NumberFormat('en-IN').format(value);
                          }
                      }
                  }
              }
          }
      });
      
      const dropdownToggle = document.querySelector('.dropdown-toggle');
      if (dropdownToggle) {
          dropdownToggle.addEventListener('click', function(e) {
              if (window.innerWidth <= 768) {
                  e.preventDefault();
                  const dropdownMenu = this.nextElementSibling;
                  dropdownMenu.classList.toggle('show');
              }
          });
      }
    });
  </script>
</body>
</html>