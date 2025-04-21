<?PHP
    session_start();
    if(!isset($_SESSION['userid']))
    {
        echo "<script>window.open('login.php','_self')</script>";
    }
    include 'connection.php';
    include 'functions.php';
    $userid=$_SESSION['userid'];
    $sql="SELECT * FROM `vendor` WHERE `UserID`='$userid'";
    $result=mysqli_query($con,$sql);
    $rows=mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockWise: Manage Vendors</title>
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
        
        /* Vendor container styling */
        .vendor-container {
            width: 100%;
            max-width: 900px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            margin: 20px auto;
            overflow-y: auto;
            max-height: 85vh;
        }
        
        .vendor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }
        
        .vendor-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .vendor-table th {
            background-color: #0d6efd;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .vendor-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        
        .vendor-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .vendor-table .action-cell {
            text-align: center;
            width: 100px;
        }
        
        .btn-action {
            padding: 5px 10px;
            margin: 0 3px;
            border-radius: 4px;
            font-size: 0.85rem;
        }
        
        /* Add vendor form styling */
        .add-vendor-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 8px 12px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        
        /* Animation for new vendor row */
        @keyframes highlightRow {
            0% { background-color: #d1ecf1; }
            100% { background-color: transparent; }
        }
        
        .new-vendor-row {
            animation: highlightRow 2s ease-in-out;
        }
        
        /* Modal styling */
        .modal-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 5px 5px 0 0;
        }
        
        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px;
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
            
            .vendor-container {
                padding: 15px;
                max-width: 100%;
            }
            
            .vendor-table {
                font-size: 0.9rem;
            }
            
            .vendor-table th, .vendor-table td {
                padding: 10px 8px;
            }
            
            .btn-action {
                padding: 4px 8px;
                font-size: 0.8rem;
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
            
            .vendor-container {
                padding: 10px;
            }
            
            .vendor-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .vendor-header h2 {
                margin-bottom: 10px;
            }
            
            .vendor-table {
                font-size: 0.8rem;
            }
            
            .vendor-table th, .vendor-table td {
                padding: 8px 5px;
            }
            
            .btn-action {
                padding: 3px 6px;
                font-size: 0.75rem;
                margin: 2px 1px;
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
            <a href="manage_vendors.php" class="nav-link active">
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
      <div class="vendor-container">
        <div class="vendor-header">
          <h2><i class="fas fa-handshake me-2"></i>Vendors</h2>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVendorModal">
            <i class="fas fa-plus me-1"></i> Add New Vendor
          </button>
        </div>
        <?PHP
            if($rows>0)
          {
        ?>
        <!-- Vendor Table -->
        <div class="table-responsive">
          <table class="vendor-table table">
            <thead>
              <tr>
                <th>Vendor ID</th>
                <th>Vendor Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th class="action-cell">Actions</th>
              </tr>
            </thead>
            <tbody id="vendorTableBody">
              <!-- Sample vendor data (for frontend demo only) -->
              <?PHP
                while($row=mysqli_fetch_assoc($result))
                {
              echo "
              <tr>
                <td>".$row['VendorID']."</td>
                <td>".$row['Name']."</td>
                <td>".$row['Number']."</td>
                <td>".$row['Email']."</td>
                <td class='action-cell'>
                  <a href='delete.php?vendor=".$row['VendorID']."'><button class='btn btn-sm btn-danger btn-action' onclick='deleteVendor(this)'>
                    <i class='fas fa-trash-alt'></i>
                  </button></a>
                </td>
              </tr>"; }?>
            </tbody>
          </table>
        </div>
        <?PHP
            }
            else
            {
                echo "<div class='alert alert-danger' role='alert'>
  Vendor Not Available!
</div>";
            }
        ?>
        <!-- No vendors message (hidden by default) -->
        <div id="noVendorsMessage" class="alert alert-info text-center" style="display: none;">
          <i class="fas fa-info-circle me-2"></i> No vendors found. Add a new vendor to get started.
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add Vendor Modal -->
  <div class="modal fade" id="addVendorModal" tabindex="-1" aria-labelledby="addVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addVendorModalLabel"><i class="fas fa-plus-circle me-2"></i>Add New Vendor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addVendorForm" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
              <label for="vendorName" class="form-label">Vendor Name</label>
              <input type="text" class="form-control" id="vendorName" required name="name">
            </div>
            <div class="mb-3">
              <label for="vendorPhone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="vendorPhone" required name="phone">
            </div>
            <div class="mb-3">
              <label for="vendorEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="vendorEmail" required name="email">
            </div>
            <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" name="add">Add Vendor</button>
        </div>
          </form>
        </div>
        
        <?PHP
            if(isset($_POST['add']))
            {
                $name=$_POST['name'];
                $phone=$_POST['phone'];
                $email=$_POST['email'];
                $sql="INSERT INTO `vendor` (`Name`,`Number`,`Email`,`UserID`) VALUES ('$name','$phone','$email','$userid')";
                $result=mysqli_query($con,$sql);
                echo "<script>window.open('manage_vendors.php','_self')</script>";
            }
        ?>
      </div>
    </div>
  </div>
  
  <!-- Delete Confirmation Modal -->
  <!-- <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this vendor?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
      </div>
    </div>
  </div> -->

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
      
      // Check if vendor table is empty
      checkVendorTable();
    });
    
    // Function to add a new vendor (frontend only)
    // function addVendor() {
    //   // Get form values
    //   const vendorName = document.getElementById('vendorName').value;
    //   const vendorPhone = document.getElementById('vendorPhone').value;
    //   const vendorEmail = document.getElementById('vendorEmail').value;
      
    //   if (!vendorName || !vendorPhone || !vendorEmail) {
    //     alert('Please fill in all required fields');
    //     return;
    //   }
      
    //   // Generate a random vendor ID (for frontend demo)
    //   const vendorId = 'V' + String(Math.floor(Math.random() * 900) + 100);
      
    //   // Create new table row
    //   const newRow = document.createElement('tr');
    //   newRow.classList.add('new-vendor-row');
    //   newRow.innerHTML = `
    //     <td>${vendorId}</td>
    //     <td>${vendorName}</td>
    //     <td>${vendorPhone}</td>
    //     <td>${vendorEmail}</td>
    //     <td class="action-cell">
    //       <button class="btn btn-sm btn-danger btn-action" onclick="deleteVendor(this)">
    //         <i class="fas fa-trash-alt"></i>
    //       </button>
    //     </td>
    //   `;
      
    //   // Add row to table
    //   document.getElementById('vendorTableBody').appendChild(newRow);
      
    //   // Reset form and close modal
    //   document.getElementById('addVendorForm').reset();
    //   const modal = bootstrap.Modal.getInstance(document.getElementById('addVendorModal'));
    //   modal.hide();
      
    //   // Check if vendor table is empty
    //   checkVendorTable();
      
    //   // Show success toast
    //   showToast('Vendor added successfully!', 'success');
    // }
    
    // Function to delete a vendor (frontend only)
    function deleteVendor(button) {
      // Store reference to the row
      const row = button.closest('tr');
      
      // Show confirmation modal
      const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
      deleteModal.show();
      
      // Set up confirm button action
      document.getElementById('confirmDeleteBtn').onclick = function() {
        // Remove the row
        row.remove();
        
        // Hide modal
        deleteModal.hide();
        
        // Check if vendor table is empty
        checkVendorTable();
        
        // Show success toast
        showToast('Vendor deleted successfully!', 'success');
      };
    }
    
    // Function to check if vendor table is empty
    function checkVendorTable() {
      const tableBody = document.getElementById('vendorTableBody');
      const noVendorsMessage = document.getElementById('noVendorsMessage');
      
      if (tableBody.children.length === 0) {
        noVendorsMessage.style.display = 'block';
      } else {
        noVendorsMessage.style.display = 'none';
      }
    }
    
    // Function to show toast notifications
    function showToast(message, type = 'info') {
      // Create toast container if it doesn't exist
      let toastContainer = document.querySelector('.toast-container');
      if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(toastContainer);
      }
      
      // Create toast element
      const toastId = 'toast-' + Date.now();
      const toastEl = document.createElement('div');
      toastEl.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary'}`;
      toastEl.id = toastId;
      toastEl.setAttribute('role', 'alert');
      toastEl.setAttribute('aria-live', 'assertive');
      toastEl.setAttribute('aria-atomic', 'true');
      
      toastEl.innerHTML = `
        <div class="d-flex">
          <div class="toast-body">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            ${message}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      `;
      
      // Add toast to container
      toastContainer.appendChild(toastEl);
      
      // Initialize and show toast
      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
      
      // Remove toast after it's hidden
      toastEl.addEventListener('hidden.bs.toast', function() {
        toastEl.remove();
      });
    }
