<?PHP
  session_start();
  if(!isset($_SESSION['userid']))
  {
    echo "<script>window.open('login.php','_self')</script>";
  }
  include 'connection.php';
  include 'functions.php';
  $userid=$_SESSION['userid'];
  $sql="SELECT * FROM `order` WHERE `UserID`='$userid' and `OrderType`='sales'";
  $result=mysqli_query($con,$sql);
  $rows=mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StockWise: Profit</title>
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

    .profit-container {
      padding: 20px;
    }

    .profit-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .profit-table th,
    .profit-table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    .profit-table th {
      background-color: #f2f2f2;
    }

    .profit-table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .profit-table tr:hover {
      background-color: #f0f0f0;
    }

    .add-profit-btn {
      margin-bottom: 20px;
    }

    .profit-graph {
      margin-bottom: 20px;
      max-width: 100%;
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

    @media (max-width: 576px) {
      .profit-table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
      }

      .modal-content {
        width: 90%;
        margin: 20% auto;
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
            <a href="profit.php" class="nav-link active">
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
      <div id="page-profit" class="page-section profit-container">
        <h2>Profit</h2>
        <!-- <button id="addProfitBtn" class="btn btn-primary add-profit-btn">Add Profit Record</button> -->
        <?PHP
          if($rows>0)
          {
        ?>
        <table class="profit-table table table-responsive">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Item Name</th>
              <th>Quantity</th>
              <th>Bill Amount (Rs)</th>
              <th>Total Selling Price (Rs)</th>
              <th>Total Purchase Price (Rs)</th>
              <th>Profit (Rs)</th>
            </tr>
          </thead>
          <tbody>
            <?PHP
              while($row=mysqli_fetch_assoc($result))
              {
                $product=$row['ProductID'];
                $sql1="SELECT * FROM `product` WHERE `ProductID`='$product'";
                $result1=mysqli_query($con,$sql1);
                $row1=mysqli_fetch_assoc($result1);
                $sp=$row1['SP'];
                $pp=$row1['PP'];
                $qty=$row['Quantity'];
                $tsp=$qty*$sp;
                $tpp=$qty*$pp;
                $profit=$tsp-$tpp;
                echo "<tr>
              <td>".$row['OrderID']."</td>
              <td>".$row['Name']."</td>
              <td>".$row['Quantity']."</td>
              <td>".$row['BillAmt']."</td>
              <td>".$tsp."</td>
              <td>".$tpp."</td>
              <td>".$profit."</td>
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
  Profit Analysis Not Available!
</div>";
          }
        ?>
      </div>

      <!-- <div id="addProfitModal" class="modal">
        <div class="modal-content">
          <span class="close">×</span>
          <h2>Add Profit Record</h2>
          <div class="modal-body">
            <input type="text" id="profitOrderID" placeholder="Order ID">
            <input type="text" id="profitItemName" placeholder="Item Name">
            <input type="number" id="profitQuantity" placeholder="Quantity">
            <input type="number" id="billAmount" placeholder="Bill Amount ($)">
            <input type="number" id="totalPurchasePrice" placeholder="Total Purchase Price ($)">
            <input type="number" id="totalSellingPrice" placeholder="Total Selling Price ($)">
            <button id="saveProfitBtn" class="btn btn-success">Save Profit Record</button>
          </div>
        </div>
      </div> -->
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

      const addProfitBtn = document.getElementById('addProfitBtn');
      const addProfitModal = document.getElementById('addProfitModal');
      const profitCloseBtn = addProfitModal.querySelector('.close');
      const saveProfitBtn = document.getElementById('saveProfitBtn');
      const profitTableBody = document.querySelector('.profit-table tbody');

      let profitChart;

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

      // function isDuplicateProfitOrderId(orderId) {
      //   const rows = profitTableBody.querySelectorAll('tr');
      //   for (let row of rows) {
      //     if (row.cells[0].textContent === orderId) {
      //       return true;
      //     }
      //   }
      //   return false;
      // }

      // addProfitBtn.addEventListener('click', function() {
      //   addProfitModal.style.display = 'block';
      // });

      // profitCloseBtn.addEventListener('click', function() {
      //   addProfitModal.style.display = 'none';
      // });

      saveProfitBtn.addEventListener('click', function() {
        const orderID = document.getElementById('profitOrderID').value;
        const itemName = document.getElementById('profitItemName').value;
        const quantity = parseInt(document.getElementById('profitQuantity').value);
        const billAmount = parseFloat(document.getElementById('billAmount').value);
        const totalPurchasePrice = parseFloat(document.getElementById('totalPurchasePrice').value);
        const totalSellingPrice = parseFloat(document.getElementById('totalSellingPrice').value);

        if (orderID && itemName && !isNaN(quantity) && !isNaN(billAmount) && !isNaN(totalPurchasePrice) && !isNaN(totalSellingPrice) && quantity >= 0 && billAmount >= 0 && totalPurchasePrice >= 0 && totalSellingPrice >= 0) {
          if (isDuplicateProfitOrderId(orderID)) {
            alert('Order ID already exists. Please use a unique ID.');
            return;
          }
          const profit = totalSellingPrice - totalPurchasePrice;
          const newRow = document.createElement('tr');
          newRow.innerHTML = `
            <td>${orderID}</td>
            <td>${itemName}</td>
            <td>${quantity}</td>
            <td>${billAmount.toFixed(2)}</td>
            <td>${totalPurchasePrice.toFixed(2)}</td>
            <td>${profit.toFixed(2)}</td>
            <td>${totalSellingPrice.toFixed(2)}</td>
            <td><button class="btn btn-sm btn-danger delete-profit" data-order-id="${orderID}">Delete</button></td>
          `;
          profitTableBody.appendChild(newRow);

          addProfitModal.style.display = 'none';
          document.getElementById('profitOrderID').value = '';
          document.getElementById('profitItemName').value = '';
          document.getElementById('profitQuantity').value = '';
          document.getElementById('billAmount').value = '';
          document.getElementById('totalPurchasePrice').value = '';
          document.getElementById('totalSellingPrice').value = '';

          updateProfitChart();
        } else {
          alert('Please fill in all fields with valid values');
        }
      });

      profitTableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-profit')) {
          const orderId = e.target.getAttribute('data-order-id');
          const row = e.target.closest('tr');
          if (row) {
            const itemName = row.cells[1].textContent;
            if (confirm(`Are you sure you want to delete profit record ${orderId} for ${itemName}?`)) {
              row.remove();
              updateProfitChart();
            }
          }
        }
      });

      function updateProfitChart() {
        const rows = profitTableBody.querySelectorAll('tr');
        const labels = [];
        const profits = [];

        rows.forEach(row => {
          labels.push(row.cells[0].textContent);
          profits.push(parseFloat(row.cells[5].textContent));
        });

        if (profitChart) {
          profitChart.data.labels = labels;
          profitChart.data.datasets[0].data = profits;
          profitChart.update();
        } else {
          const ctx = document.getElementById('profitChart').getContext('2d');
          profitChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: labels,
              datasets: [{
                label: 'Profit (Rs)',
                data: profits,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
              }]
            },
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
        }
      }

      window.addEventListener('click', function(event) {
        if (event.target === addProfitModal) {
          addProfitModal.style.display = 'none';
        }
      });

      const navLinks = document.querySelectorAll('.nav-link');
      navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const target = this.getAttribute('href').substring(1);
          showSection(target);
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

      const initialActive = document.querySelector('.nav-link.active');
      if (initialActive) {
        const initialTarget = initialActive.getAttribute('href').substring(1);
        showSection(initialTarget);
      }

      updateProfitChart();
    });
  </script>
</body>
</html>