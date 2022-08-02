<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>WBCT-CMS - Home</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Vendor CSS Files -->
  <!-- <link href="assets/vendor/aos/aos.css" rel="stylesheet"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->
  <!-- <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet"> -->
  <!-- <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet"> -->
  <!-- <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet"> -->
  <!-- <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">



  <!-- Jquery CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script type="text/javascript">
    window.history.forward();

    function noBack() {
      window.history.forward();
    }
  </script>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container">
      <div class="header-container d-flex align-items-center justify-content-between">
        <div class="logo">
          <h1 class="text-light"><a href="index.html"><span>WBCT-CMS</span></a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
          <ul>
            <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
            <li><a class="nav-link scrollto" href="#about">About</a></li>
            <li><a class="nav-link scrollto" href="#devBy">Dev By</a></li>
            <li><a class="nav-link scrollto" target="_blank" href="./assets/pdf/report.pdf" download>Project Report</a>
            </li>
            <li><a class="nav-link" data-bs-toggle="modal" data-bs-target="#custLoginModal"
                onclick="popUpSignInModal2()">Customer Dashboard</a></li>
            <li><a class="nav-link" data-bs-toggle="modal" data-bs-target="#coLoginModal"
                onclick="popUpSignInModal()">C.O. Dashboard</a></li>
            <li><a class="getstarted scrollto" href="#about">Get Started</a></li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->


        <!-- customer Login Modal -->
        <div class="modal fade" id="custLoginModal" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="nav-item signInTab2">
                    <a class="nav-link  signInTab active" data-bs-toggle="tab" href="#signIn"
                      onclick="resetSignInForm()">Sign In</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link signUpTab" data-bs-toggle="tab" href="#signUp" onclick="resetSignUpForm()">Sign
                      Up</a>
                  </li>
                </ul>
                <!--End  Nav tabs -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- Tab panes -->
                <div class="tab-content">
                  <!-- sign in form -->
                  <div class="tab-pane container active" id="signIn">
                    <div id="signInFrmWork">
                      <form id="signInForm">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="custfloatingInput" placeholder="8876XXXXXX"
                            name="custfloatingInput">
                          <label for="custfloatingInput">Mobile Number</label>
                        </div>
                        <div class="form-floating">
                          <input type="password" class="form-control" id="custfloatingPassword" placeholder="Password"
                            name="custfloatingPassword">
                          <label for="custfloatingPassword">Password</label>
                        </div>
                      </form>
                      <div class="m-3 w-100 d-flex align-items-center justify-content-between">
                        <span>
                          <input class="form-check-input" type="checkbox" value=0 id="checkbx" onclick="pswToggle()">
                          <label class="form-check-label mr-2" for="checkbx" id="labelText">
                          </label>
                        </span>
                        <button type="button" class="btn btn-success" onclick="custSignIn()">Sign In</button>
                      </div>
                      <div class="w-100 d-flex align-items-center justify-content-center">
                        <p class="p-2"><span class="btmLink" onclick="forgotPswClik2()">Forgotten Password</span> |
                          <span class="btmLink" onclick="redirectSignUp()">Not
                            Registered Yet ?</span></p>
                      </div>
                    </div>
                    <!-- /*********************************
                       Customer Forgot password section Start
                    *************************************/ -->
                    <div id="fortogPswCustSection">
                      <div id="regMobileNoInputAndValidation2">
                        <form id="custRegPhNoValidation">
                          <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="CustfloatingInputForPhNo"
                              name="CustfloatingInputForPhNo" placeholder="8876XXXXXX">
                            <label for="CustfloatingInputForPhNo">Enter Reg. Ph. Number</label>
                          </div>
                          <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="CustfloatingInputForName"
                              name="CustfloatingInputForName" placeholder="John">
                            <label for="CustfloatingInputForName">Enter Your Name</label>
                          </div>
                        </form>
                        <div class="mt-3 w-100 d-flex align-items-center justify-content-between">
                          <button type="button" class="btn btn-success" onclick="backToSignInCust()">Back</button>
                          <button type="button" class="btn btn-success" onclick="phNoValidationAndSendOTPCust()">Send
                            OTP</button>
                        </div>
                      </div>
                    </div>

                    <!-- /*********************************
                  OTP Verification Section Start
                  *********************************/ -->
                    <div id="custOTPVerification">
                      <div class="w-100 d-flex align-items-center justify-content-center">
                        <img src="./assets/img/otpBG_Artboard 1.jpg" alt="OTPBG" class="mb-3 w-75">
                      </div>
                      <!-- <input type="text" value=0 id="adminEmpId"> -->
                      <div class="w-100 p-3 d-flex align-items-center justify-content-center">
                        <h6 class="text-bold">Enter OTP sent to your ph number.</h6>
                      </div>
                      <div id="optInputs" class="w-100 d-flex align-items-center justify-content-around">
                        <form id="otpInputsFormForCustPswReset">
                          <input type="text" autofocus id="otpInput" class="n1OTPCustPswReset inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                          <input type="text" id="otpInput" class="n2OTPCustPswReset inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                          <input type="text" id="otpInput" class="n3OTPCustPswReset inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                          <input type="text" id="otpInput" class="n4OTPCustPswReset inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                        </form>
                      </div>
                      <div class="w-100 d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-success m-4"
                          onclick="verifyOTPForCustPswReset()">Verify</button>
                      </div>
                    </div>
                    <!-- /*********************************
                  OTP Verification Section End
                  *********************************/ -->

                    <!-- /*************************
                  Reset Customer password section start
                   ************************/ -->
                    <div id="createNewPswForCust">
                      <div class="w-100 p-3 d-flex align-items-center justify-content-center">
                        <h6 class="text-bold">Reset Your Password.</h6>
                      </div>
                      <form id="custPswResetForm">
                        <input type="hidden" value=0 id="custIdHidden" name="hiddenCustId">
                        <input type="hidden" value=0 id="custPhHidden" name="hiddenCustPh">
                        <div class="form-floating mb-3">
                          <input type="password" class="form-control" id="CustfloatingInputForPsw"
                            name="CustfloatingInputForPsw" placeholder="8876XXXXXX">
                          <label for="CustfloatingInputForPsw">Enter New Password</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" class="form-control" id="CustfloatingInputForConfirm"
                            name="CustfloatingInputForConfirm" placeholder="John">
                          <label for="CustfloatingInputForConfirm">Enter Confirm Password</label>
                        </div>
                      </form>
                      <div class="m-3 w-100 d-flex align-items-center justify-content-between">
                        <span>
                          <input class="form-check-input" type="checkbox" value=0 id="checkbxCustPswUpdate"
                            onclick="pswToggleCustUpdatePsw()">
                          <label class="form-check-label mr-2" for="checkbxCustPswUpdate"
                            id="labelTextForCustPswUpdate">
                          </label>
                        </span>
                        <button type="button" class="btn btn-success" onclick="custUpdateNewPsw()">Update</button>
                      </div>
                    </div>
                    <!-- /*************************
                  Reset Customer password section end
                   ************************/ -->
                  </div>
                  <!-- end sign in form -->

                  <!-- sign up form -->
                  <div class="tab-pane container fade" id="signUp">
                    <div id="signUpFrmWork">
                      <form id="CustSignUpForm">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control custName" id="CustfloatingPassword"
                            name="custNameCustSignUP" placeholder="Jhon">
                          <label for="CustfloatingPassword">Full Name</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control custPhNo" id="CustfloatingPassword"
                            name="phNumberCustSignUP" placeholder="8876XXXXXX">
                          <label for="CustfloatingPassword">Mobile Number</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="email" class="form-control custEmail" id="CustfloatingPassword"
                            name="emailCustSignUP" placeholder="jhon@xyz.com">
                          <label for="CustfloatingPassword">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" class="form-control custPsw" id="CustfloatingPassword"
                            placeholder="Password" name="custPswCustSignUP">
                          <label for="custfloatingPassword">Password</label>
                        </div>
                        <div class="form-floating">
                          <input type="password" class="form-control custConfirmPsw" id="CustfloatingConfirmPassword"
                            placeholder="Confirm Password" name="custConfirmPsw">
                          <label for="custfloatingPassword">Confirm Password</label>
                        </div>
                      </form>

                      <div class="m-3 w-100 d-flex align-items-center justify-content-between">
                        <span>
                          <input class="form-check-input" type="checkbox" value=0 id="checkbx2" onclick="pswToggle2()">
                          <label class="form-check-label mr-2" for="checkbx2" id="labelText2">
                          </label>
                        </span>
                        <button type="button" class="btn btn-success" onclick="custSignUp()">Sign Up</button>
                      </div>
                    </div>

                    <!-- OTP verification -->
                    <div id="otpVarification" class="animate__animated animate__fadeIn">
                      <div class="w-100 d-flex align-items-center justify-content-center">
                        <img src="./assets/img/otpBG_Artboard 1.jpg" alt="OTPBG" class="mb-3 w-75">
                      </div>
                      <div class="w-100 p-3 d-flex align-items-center justify-content-center">
                        <h6 class="text-bold">Enter OTP sent to your mobile number.</h6>
                      </div>
                      <div id="optInputs" class="w-100 d-flex align-items-center justify-content-around">
                        <form id="otpInputsForm">
                          <input type="hidden" value=0 id="hiddenTempCustId">
                          <input type="text" autofocus id="otpInput" class="n1OTP inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                          <input type="text" id="otpInput" class="n2OTP inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                          <input type="text" id="otpInput" class="n3OTP inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                          <input type="text" id="otpInput" class="n4OTP inputs" maxlength="1"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                        </form>
                      </div>
                      <div class="w-100 d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-success m-4" onclick="verifyOTP()">Verify</button>
                      </div>
                    </div>

                    <!-- Signup success tab -->
                    <div id="signupSuccessTab" class="w-100">
                      <div class="w-100 d-flex align-items-center justify-content-center">
                        <img src="./assets/img/signUpSuccessBG-01.jpg" alt="SuccessFullySignUpImg" class="w-75">
                      </div>
                      <div class="w-100 d-flex flex-column align-items-center justify-content-center p-2 mt-3 mb-3">
                        <h1>Greate...</h1>
                        <h4>Registration completed successfully</h4>
                      </div>
                      <div class="w-100 d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-success m-4" onclick="redirectSignIn()">Click for sign
                          in</button>
                      </div>

                    </div>

                  </div>
                  <!-- end signup form -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End customer Login Modal -->

      <!-- C.O. Login Modal -->
      <div class="modal fade" id="coLoginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <!-- /***************************
              Admin, Employee Sign In Section Start
            **************************************/-->
              <div id="signInFrmWork" class="adminEmpDiv">
                <form id="signInFormForCO">
                  <div class="mb-3">
                    <select class="form-select" id="CORole" name="CORole" aria-label="Default select example">
                      <option value="" selected>Select SignIn Type</option>
                      <option value="admin">Admin</option>
                      <option value="employee">Employee</option>
                    </select>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="COfloatingInput" name="COfloatingInput"
                      placeholder="8876XXXXXX">
                    <label for="COfloatingInput">Mobile Number</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="COfloatingPassword" name="COfloatingPassword"
                      placeholder="Password">
                    <label for="COfloatingPassword">Password</label>
                  </div>
                </form>
                <div class="m-3 w-100 d-flex align-items-center justify-content-between">
                  <span>
                    <input class="form-check-input" type="checkbox" value=0 id="checkbxCO" onclick="pswToggleCO()">
                    <label class="form-check-label mr-2" for="checkbxCO" id="labelTextCO">
                    </label>
                  </span>
                  <button type="button" class="btn btn-success" onclick="COSignIn()">Sign In</button>
                </div>
                <div class="w-100 d-flex align-items-center justify-content-center">
                  <p class="p-2" onclick="forgotPswClik()"><span class="btmLink">Forgotten Password</span></p>
                </div>
              </div>
              <!-- /***************************
              Admin, Employee Sign In Section End
            **************************************/-->

              <!-- /*********************************
            Admin, Employee, Forgot password section Start
            *************************************/ -->
              <div id="fortogPswAdminEmployeeSection">
                <div id="regMobileNoInputAndValidation">
                  <form id="empAdminRegPhNoValidation">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="COfloatingInputForPhNo" name="COfloatingInputForPhNo"
                        placeholder="8876XXXXXX">
                      <label for="COfloatingInputForPhNo">Enter Reg. Ph. Number</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="COfloatingInputForName" name="COfloatingInputForName"
                        placeholder="John">
                      <label for="COfloatingInputForName">Enter Your Name</label>
                    </div>
                  </form>
                  <div class="mt-3 w-100 d-flex align-items-center justify-content-between">
                    <button type="button" class="btn btn-success" onclick="backToSignInCO()">Back</button>
                    <button type="button" class="btn btn-success" onclick="phNoValidationAndSendOTPAdminEmp()">Send
                      OTP</button>
                  </div>
                </div>

                <!-- /*********************************
                  OTP Verification Section Start
                  *********************************/ -->
                <div id="adminEmpOTPVerification">
                  <div class="w-100 d-flex align-items-center justify-content-center">
                    <img src="./assets/img/otpBG_Artboard 1.jpg" alt="OTPBG" class="mb-3 w-75">
                  </div>
                  <!-- <input type="text" value=0 id="adminEmpId"> -->
                  <div class="w-100 p-3 d-flex align-items-center justify-content-center">
                    <h6 class="text-bold">Enter OTP sent to your ph number.</h6>
                  </div>
                  <div id="optInputs" class="w-100 d-flex align-items-center justify-content-around">
                    <form id="otpInputsFormForAdminEmpPswReset">
                      <input type="text" autofocus id="otpInput" class="n1OTPAdminEmpPswReset inputs" maxlength="1"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                      <input type="text" id="otpInput" class="n2OTPAdminEmpPswReset inputs" maxlength="1"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                      <input type="text" id="otpInput" class="n3OTPAdminEmpPswReset inputs" maxlength="1"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                      <input type="text" id="otpInput" class="n4OTPAdminEmpPswReset inputs" maxlength="1"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="&#9679">
                    </form>
                  </div>
                  <div class="w-100 d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-success m-4"
                      onclick="verifyOTPForAdminEmpPswReset()">Verify</button>
                  </div>
                </div>
                <!-- /*********************************
                  OTP Verification Section End
                  *********************************/ -->

                <!-- /*************************
                  Reset admin or emp password section start
                   ************************/ -->
                <div id="createNewPswForAdminEmp">
                  <div class="w-100 p-3 d-flex align-items-center justify-content-center">
                    <h6 class="text-bold">Reset Your Password.</h6>
                  </div>
                  <form id="empOrAdminPswResetForm">
                    <input type="hidden" value=0 id="adminEmpId" name="hiddenAdminorEmpId">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="COfloatingInputForPsw"
                        name="COfloatingInputForPsw" placeholder="8876XXXXXX">
                      <label for="COfloatingInputForPsw">Enter New Password</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="COfloatingInputForConfirm"
                        name="COfloatingInputForConfirm" placeholder="John">
                      <label for="COfloatingInputForConfirm">Enter Confirm Password</label>
                    </div>
                  </form>
                  <div class="m-3 w-100 d-flex align-items-center justify-content-between">
                    <span>
                      <input class="form-check-input" type="checkbox" value=0 id="checkbxAdminOrEmpPswUpdate"
                        onclick="pswToggleCOUpdatePsw()">
                      <label class="form-check-label mr-2" for="checkbxAdminOrEmpPswUpdate"
                        id="labelTextForAdminOrEmpPswUpdate">
                      </label>
                    </span>
                    <button type="button" class="btn btn-success" onclick="empOrAdminUpdateNewPsw()">Update</button>
                  </div>
                </div>
                <!-- /*************************
                  Reset admin or emp password section end
                   ************************/ -->


              </div>
              <!-- /*********************************
            Admin, Employee, Forgot password section End
            *************************************/ -->

            </div>
          </div>
        </div>
      </div>
      <!-- End C.O. Login Modal -->

    </div><!-- End Header Container -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container text-center position-relative" data-aos="fade-in" data-aos-delay="200">
      <h1 class="fs-2">Web Based Cable TV Customer Management System</h1>
      <h2>MCA 3rd Semester Minor Project , GIMT , Guwahati</h2>
      <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row content">
          <div class="col-lg-6">
            <h2>A small description of our project </h2>
            <h3>Web Based Cable TV Customer Management System (WBCT-CMS)</h3>
            <button type="button" class="btn btn-outline-success"> <a target="_blank" href="./assets/pdf/report.pdf"
                download>Download Project Report</a> </button>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-left" data-aos-delay="200">
            <p>
              Web based Cable TV customer management system.
              This is a web based system for a Cable TV operator to manage their customers. In this system the customer
              can register on the website for a new connection and can get full access to their account. The customer
              can select new package, add package or drop existing package, view bill or recharge account, they can also
              lodge a complaint or view the status of their query. The Cable TV operator employee can manage the
              connections, view and resolve customer complaints and manage the packages.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container">

        <div class="row counters">

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/html.png" alt="html" id="icn-progeramming">
            <p>HTML</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/CSS.png" alt="css" id="icn-progeramming">
            <p>CSS</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/jquery.png" alt="jquery" id="icn-progeramming">
            <p>JQuery</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/bootstrap.png" alt="bootstrap" id="icn-progeramming">
            <p>Bootstrap</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/PHP.png" alt="php" id="icn-progeramming">
            <p>PHP</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/MySQL.png" alt="mysql" id="icn-progeramming">
            <p>MySQL</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/xaamp.png" alt="xaamp" id="icn-progeramming">
            <p>XAAMP</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <img src="./assets/img/vsCodeEditor.png" alt="Vscodeeditor" id="icn-progeramming">
            <p>VS Code Editor</p>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->




    </div>
    <div class="swiper-pagination"></div>
    </div>
    </div>
    </div>

    </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= DEvBy Section ======= -->
    <section id="devBy" class="team">
      <div class="container">

        <div class="row">
          <div class="col-lg-4">
            <div class="section-title">
              <h2>Developed By</h2>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="row">

              <div class="col-lg-6">
                <div class="member" data-aos="zoom-in" data-aos-delay="100">
                  <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>Jayanta Das</h4>
                    <span>MCA 3rd Semester</span>
                    <span>Roll no - 200320014013</span>
                  </div>
                </div>
              </div>

           


            </div>

          </div>
        </div>

      </div>
    </section><!-- End Team Section -->



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
  <!-- <script src="assets/vendor/aos/aos.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <!-- Sweet alert  -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- function JS -->
  <script src="assets/js/fun.js"></script>
</body>

</html>