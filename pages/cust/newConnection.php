<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>WBCT-CMS - Customer - New Connection </title>
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

</head>

<body>
    <?php 
    session_start();
    if(isset($_SESSION['custSessionIdTemp']) && !empty($_SESSION['custSessionIdTemp'])) 
    {
      echo "<input type='hidden' value=".$_SESSION['custSessionIdTemp']." id='sessionId' style='margin-left:300px'>";
      echo "<input type='hidden' value='custTemp' id='custType' style='margin-left:300px'>";
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
                        <li style="cursor:pointer">
                            <a class="getstarted scrollto" onclick="sign_Out_Cust()">Sign Out <i
                                    class="fas fa-sign-out-alt"></i></a>
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
                    <h2>New Connection</h2>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Portfolio Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="alert alert-info" role="alert" id="paySTS">
                    Your Payment Reqest Has Been Sent To Cable Operator 
                </div>
                <div class="row gy-4">

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                Fill Your Address
                            </div>
                            <div class="card-body">
                                <form id="newConnForm">
                                    <div class="row g-2">
                                        <div class="col-md">
                                            <div class="form-floating">
                                                <input type="email" class="form-control"
                                                    id="floatingInputGridForHouseNO" placeholder="e.g. 26" value="">
                                                <label for="floatingInputGridForHouseNO">Enter House Number</label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-floating" id="areaSelect">
                                                
                                            </div>
                                        </div>
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="floatingInputForPinCode"
                                                placeholder="e.g. 781009" value="">
                                            <label for="floatingInputForPinCode">Enter Pincode</label>
                                        </div>
                                    </div>
                                </form>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <button class="btn btn-success sbmtBtn" type="button"
                                        onclick="submitData()">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-2">
                            <button class="btn btn-success sendConnReqst" type="button"
                                onclick="sendConnRequestFn()">Send Connection Request</button>
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
                            </ul>
                            <div class="d-grid gap-2">
                                <button class="btn btn-success showConnSts" type="button" data-bs-toggle="modal"
                                    data-bs-target="#showConnREqstSts" onclick="getConnReqstStatusFn()">
                                    Show Connection request Status
                                </button>
                                <button class="btn btn-success makePay" type="button" data-bs-toggle="modal"
                                    data-bs-target="#showAllPkg" onclick="getCustPkgData()">
                                    Make Payment
                                </button>
                            </div>
                        </div>
                        <div class="portfolio-info mt-3" id="cableOperatorInfo">
                            <h3>Cable Operator Information</h3>
                            <ul>
                                <li><strong>Full Name</strong>:
                                    <span id="cOName"></span>
                                </li>
                                <li><strong>Mobile Number</strong>:
                                    <span id="cOPhNumber"></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Portfolio Details Section -->

        <!-- SHOW COnnection Status Modal -->
        <div class="modal fade" id="showConnREqstSts" tabindex="-1" aria-labelledby="showConnREqstStsLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showConnREqstStsLabel">Connection Request Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body connStsModalBody">
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="showAllPkg" tabindex="-1" aria-labelledby="showAllPkgLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showAllPkgLabel">Select Packages</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body allPkgs">

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hiddenEmail" value="">
                        <button type="button" class="btn btn-success" onclick="proceedToPay()">Proceed To Pay</button>
                    </div>
                </div>
            </div>
        </div>



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
    <script src="./js/newConnection.js"></script>

</body>

</html>