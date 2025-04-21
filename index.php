<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockWise: Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="icon" type="image" href="box-seam.svg">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1d4ed8;
            --accent-color: #f59e0b;
            --dark-color: #0f172a;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 10rem 0 8rem;
            overflow: hidden;
            position: relative;
        }

        .nav-glass {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 2.5rem;
        }

        .stat-highlight {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .value-card {
            border-left: 4px solid var(--primary-color);
            padding: 2rem;
            margin: 2rem 0;
            transition: all 0.3s ease;
        }

        .footer {
            background: var(--dark-color);
            color: rgba(255,255,255,0.8);
            padding: 6rem 0 2rem;
        }

        .hero-illustration {
            animation: float 4s ease-in-out infinite;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            width: 100%;     /* Set to full width of container */
            margin: 0 auto; /* Ensure centering */
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .about-section-image {
            width: 100%; /* Ensure images fill container width */
            height: 300px; /* Set a fixed height */
            object-fit: cover; /* Scale while maintaining aspect ratio, cropping if needed */
            margin-bottom: 1rem; /* Add some space below each image */
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light nav-glass fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-box-seam fs-4" style="color: var(--primary-color);"></i>
            <span class="ms-2 fw-bold">StockWise</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li> <!-- Corrected link -->
                <li class="nav-item"><a class="nav-link" href="index.php#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#contact">Contact</a></li>
            </ul>
            <div class="ms-lg-3">
                <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                <a href="register.php" class="btn btn-primary px-4">Sign Up</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <h1 class="display-3 fw-bold mb-4 animate-on-scroll">
                    Transform Your<br>
                    <span style="color: var(--accent-color)">Inventory Management</span>
                </h1>
                <p class="lead mb-4 animate-on-scroll">
                    Stock control system with military-grade precision
                </p>
                <div class="d-flex gap-3 animate-on-scroll">
                    <a href="register.php" class="btn btn-light btn-lg px-5 py-3">Get Started</a>
                </div>
            </div>
            <div class="col-lg-7 text-center">
                <img src="photo2.jpg" alt="Dashboard Preview" 
                     class="hero-illustration img-fluid mt-5 mt-lg-0">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" id="features" style="padding: 8rem 0">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Enterprise-Grade Features</h2>
            <p class="text-muted">Military precision meets business intelligence</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 animate-on-scroll">
                <div class="feature-card">
                    <i class="bi bi-speedometer2 fs-1 text-primary mb-3"></i>
                    <h3>Real-Time Tracking</h3>
                    <p class="text-muted">Monitor stock levels across global locations in real-time</p>
                </div>
            </div>
            <div class="col-md-4 animate-on-scroll">
                <div class="feature-card">
                    <i class="bi bi-shield-lock fs-1 text-primary mb-3"></i>
                    <h3>Blockchain Audit</h3>
                    <p class="text-muted">Immutable transaction records with blockchain technology</p>
                </div>
            </div>
            <div class="col-md-4 animate-on-scroll">
                <div class="feature-card">
                    <i class="bi bi-cpu fs-1 text-primary mb-3"></i>
                    <h3>Forecasting</h3>
                    <p class="text-muted">Predictive analytics powered by machine learning</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="bg-light py-5" id="about">
    <div class="container">
        <div class="row g-5"> <!-- Removed align-items-center -->
            <div class="col-lg-6">
                <h2 class="display-4 fw-bold mb-4">
                    Precision in Every Product
                </h2>
                <div class="value-card animate-on-scroll">
                    <p class="lead mb-4">
                        At StockWise, we transform inventory chaos into clarity. Trusted by 3,800+ businesses
                        managing $4.2B in combined inventory value with 99.99% system uptime.
                    </p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6 animate-on-scroll">
                        <div class="bg-white p-4 rounded-3 shadow-sm">
                            <h3 class="stat-highlight">92%</h3>
                            <p class="text-muted mb-0">Reduction in stock errors</p>
                        </div>
                    </div>
                    <div class="col-md-6 animate-on-scroll">
                        <div class="bg-white p-4 rounded-3 shadow-sm">
                            <h3 class="stat-highlight">24/7</h3>
                            <p class="text-muted mb-0">Expert support coverage</p>
                        </div>
                    </div>
                </div>

                <div class="border-start border-3 border-primary ps-4 animate-on-scroll">
                    <h4 class="mb-3">Battle-Tested Features</h4>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-shield-check text-primary me-2"></i>
                            Military-grade security protocols
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-lightning-charge text-primary me-2"></i>
                            Real-time global synchronization
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-graph-up-arrow text-primary me-2"></i>
                            Predictive inventory forecasting
                        </li>
                    </ul>
                </div>
            </div> <!-- End of first col-lg-6 -->
            <div class="col-lg-6 animate-on-scroll pt-5">
                <img src="1-500x500.png" alt="Product illustration" class="img-fluid rounded shadow-sm about-section-image">
                <img src="smart.png" alt="Online inventory management" class="img-fluid rounded shadow-sm about-section-image">
            </div>
        </div> <!-- End of row g-5 -->
    </div> <!-- End of container -->
</section>

<!-- Footer -->
<footer class="footer" id="contact">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="text-white mb-4">StockWise</h5>
                <p class="text-white-50">Enterprise-grade inventory control for modern businesses</p>
                <div class="social-icons">
                    <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-github"></i></a>
                </div>
            </div>
            <div class="col-lg-2">
                <h6 class="text-white">Solutions</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="warehousing.html" class="text-white-50">Warehousing</a></li>
                    <li class="mb-2"><a href="retail.html" class="text-white-50">Retail</a></li>
                    <li class="mb-2"><a href="manufacturing.html" class="text-white-50">Manufacturing</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white">Legal</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="compliance.html" class="text-white-50">Compliance</a></li>
                    <li class="mb-2"><a href="security.html" class="text-white-50">Security</a></li>
                    <li class="mb-2"><a href="gdpr.html" class="text-white-50">GDPR</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white">Contact</h6>
                <ul class="list-unstyled">
                    <li class="text-white-50"><a href="mailto:stockwise.thapar@gmail.com" class="text-white-50">stockwise.thapar@gmail.com</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-5 opacity-25">
        <div class="text-center text-white-50">
            <small>&copy; 2025 StockWise. All rights reserved.</small>
        </div>
    </div>
</footer>

<script>
    // Scroll animation trigger
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach((el) => {
        observer.observe(el);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
