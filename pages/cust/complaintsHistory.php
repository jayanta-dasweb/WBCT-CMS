<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>WBCT-CMS - Customer - Complaint </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./img/logo.png" rel="icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/globelStyle.css">
  <link rel="stylesheet" href="./css/homeStyle.css">

</head>

<body>
  <?php 
    session_start();
    if(isset($_SESSION['custSessionId']) && !empty($_SESSION['custSessionId'])) 
    {
      echo "<input type='hidden' value=".$_SESSION['custSessionId']." id='sessionId' style='margin-left:300px'>";
    }
    else{
      header("Location: /wbct-cms/");
      die();
    }

  ?>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container">
      <div class="header-container d-flex align-items-center justify-content-between">
        <div class="logo">
          <h1 class="text-light"><a href="newConnection.php"><span>WBCT-CMS</span></a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
          <ul>
            <li><a class="nav-link" href="./home.php">Home</a></li>
            <li class="dropdown" style="cursor:pointer">
              <a><span>Recharge</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="./createCustPkg.php">Create Custom Package</a></li>
                <li><a href="./recharge.php" id="rechrgPg">Recharge</a></li>
                <li><a href="./rechrgHistory.php">View History</a></li>
              </ul>
            </li>
            <li class="dropdown" style="cursor:pointer">
              <a class="nav-link active"><span>Complaint</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="./giveComplaint.php">Give Complaint</a></li>
                <li><a href="./complaintsHistory.php" class="nav-link active">View History</a></li>
              </ul>
            </li>
            <li style="cursor:pointer">
              <a class="getstarted scrollto" onclick="sign_Out_Cust()">Sign Out <i class="fas fa-sign-out-alt"></i></a>
            </li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

      </div><!-- End Header Container -->
    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Complaint</h2>
          <ol>
            <li><a href="./home.php">Home</a></li>
            <li>Complaint</li>
            <li>Complaint History</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">
        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="card">
              <div class="card-header">
                <div class="w-100 d-flex align-items-center justify-content-center pl-4 pr-4">

                  <div class="w-100 d-flex align-items-center justify-content-end">
                    <!-- /************************ Search Data ****************/ -->
                    <div class="input-group mb-3 w-50 mt-3">
                      <input type="text" class="form-control" placeholder="Search" aria-label="search"
                        aria-describedby="basic-addon2" id="searchText" onkeyup="searchData()">
                      <span class="input-group-text" id="basic-addon2">
                        <i class="fas fa-search"></i>
                      </span>
                    </div>
                    <!-- /************************ Search Data END****************/ -->
                  </div>
                </div>
              </div>
              <div class="card-body" id="cardBodyTable">

              </div>

              <!-- /*************** Show Complaint modal start *********/ -->
              <div class="modal fade" id="showComplaintModal" tabindex="-1" aria-labelledby="showComplaintModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="showComplaintModalLabel">Complaint Detail
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-2">
                      <div class="w-100 p-3" id="complaintDetail">

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /*************** Show Complaint modal End *********/ -->

            </div>

          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>User Information</h3>
              <ul>
                <li>
                  <strong>Full Name</strong>:
                  <span id="name"></span>
                </li>
                <li>
                  <strong>Mobile Number</strong>:
                  <span id="phNo"></span></li>
                <li>
                  <strong>Email</strong>:
                  <span id="email"></span>
                </li>
                <li>
                  <strong>Address</strong>:
                  <span id="address"></span>
                </li>
              </ul>
            </div>
            <div class="portfolio-info mt-3">
              <h3>STB Information</h3>
              <ul>
                <li>
                  <strong>Status</strong>:
                  <span id="stbSts"></span>
                </li>
                <li>
                  <strong>STB Number</strong>:
                  <span id="stbNo"></span>
                </li>
                <li>
                  <strong>Setup Date</strong>:
                  <span id="setupDt"></span>
                </li>
              </ul>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          MCA 3rd Semester Minor Project <strong><span>GIMT-G</span></strong>
        </div>
        <div class="credits">
          Developed by <a href="https://www.linkedin.com/in/jayanta-das-88771b17a/">Jayanta Das</a>
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Sweet alert  -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="./js/globel.js"></script>
  <script src="./js/complaintHistory.js"></script>

</body>

</html>