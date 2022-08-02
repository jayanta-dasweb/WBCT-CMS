<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WBCT-CMS | Employee-Customer Transection History</title>

    <!-- Favicons -->
    <link href="../../dist/img/logo.png" rel="icon">
    <link href="../../dist/img/logo.png" rel="apple-touch-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- main CSS file for Admin  -->
    <link rel="stylesheet" href="css/mainStyle.css">

    <!-- home CSS file for home.php -->
    <link rel="stylesheet" href="css/trHistoryStyle.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<?php 
    session_start();
    if(isset($_SESSION['employeeId']) && !empty($_SESSION['employeeId'])) 
    {
      echo "<input type='hidden' value=".$_SESSION['employeeId']." id='sessionId' style='margin-left:300px'>";
    }
    else{
        header("Location: /wbct-cms/");
        die();
    }

  ?>
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="./home.php" class="brand-link">
                <img src="../../dist/img/logo.png" alt="WBCT-CMS Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">WBCT-CMS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../dist/img/user.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block" id="userName"></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="./home.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        

                        <!-- /*************** New Connection  NAV *********************/ -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-network-wired"></i>
                                <p>
                                    New Connection
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./pendingConnRequest.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pending Request
                                            <span class="badge badge-info right" id="connRequstNo"></span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- /*************** End New Connection NAV *********************/ -->

                        <!-- /*************** Complaints NAV *********************/ -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>
                                    Complaints
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./pendingComplaints.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pending Complaints
                                            <span class="badge badge-info right" id="pendingComplaintsNo"></span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./resolveComplaints.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Resolved Complaints
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- /*************** End Complaints NAV *********************/ -->

                        <!-- /*************** Complaints NAV *********************/ -->

                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Customer
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./allCust.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Customer
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./trHistory.php" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transaction History
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- /*************** End Complaints NAV *********************/ -->

                        <!-- /*************** Recharge NAV *********************/ -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tv"></i>
                                <p>
                                    Recharge
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./rechrgPendingReqst.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pending Request
                                            <span class="badge badge-info right" id="rechargeRequestNo"></span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./addCustomPkg.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Custom Package
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./recharge.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Recharge
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- /*************** End Recharge NAV *********************/ -->

                        <!-- /*********** Update Profile *********/ -->
                        <li class="nav-item">
                            <a href="./profile.php" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <!-- /************ End Update Out *********/ -->

                        <!-- /*********** Sign Out *********/ -->
                        <li class="nav-item" onclick="sign_Out_Admin()">
                            <a class="nav-link" id="signOutNav">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Sign Out
                                </p>
                            </a>
                        </li>
                        <!-- /************ End Sign Out *********/ -->

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
                                <li class="breadcrumb-item active">Transaction History</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Table  -->
                    <div class="row"">
                        <div class=" col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customer's All Transactions</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search" id="searchText" onkeyup="searchData()">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="max-height: 500px;" id="cardBodyTable">
                            </div>
                            <!-- /.card-body -->

                            <!-- /**************** Get payment details *********/ -->
                            <div class="modal fade" id="payDetailsModal" tabindex="-1"
                                aria-labelledby="payDetailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="payDetailsModalLabel">Payment Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" onclick="closeModl()"></button>
                                        </div>
                                        <div class="modal-body" id="printArea">
                                            
                                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                onclick="printInvoice()">print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /**************** Get payment details End*********/ -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- TABLE -->



                <!-- Container-fluid END -->
        </div>
    </div>
    </section>
    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Developed By <a href="https://www.linkedin.com/in/jayanta-das-88771b17a/">Jayanta Das</a>.</strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>MCA 3rd Semester</b> Minor Prject (GIMT-G)
        </div>
    </footer>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../../plugins/overlayScrollbars/js/OverlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Sweet alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- main JS file for Admin  -->
    <script src="js/mainGloble.js"></script>
    <script src="js/funGloble.js"></script>

    <!-- home JS file for home.php -->
    <script src="js/trHistoryMain.js"></script>
    <script src="js/trHistoryFun.js"></script>

</body>

</html>