<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Forgot Password - CPS</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/app-assets/images/ico/favicon2.ico">
    <link href="<?php echo base_url(); ?>assets/fonts.googleapis.com/cssc203.css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/themes/semi-dark-layout.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <!-- END: Custom CSS-->

    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/vendors.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style type="text/css">
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("loader-img.gif") center no-repeat;
        }
        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;   
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    </style>

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- forgot password start -->
<section class="row flexbox-container">
    <div class="col-xl-7 col-md-9 col-10  px-0">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-forgot password -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center mb-2">Forgot Password?</h4>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center mb-2">
                            <div class="text-left">
                                <div class="ml-3 ml-md-2 mr-1"><a href="<?php echo base_url() ?>auth/login"
                                        class="card-link btn btn-outline-primary text-nowrap">Sign
                                        in</a></div>
                            </div>
                            <!-- <div class="mr-3"><a href="auth-register.html"
                                    class="card-link btn btn-outline-primary text-nowrap">Sign
                                    up</a></div> -->
                        </div>
                        <div class="card-body">
                            <div class="text-muted text-center mb-2"><small>Enter the email address attached to your account
                                    and we will send you temporary password</small></div>
                            <form class="mb-2" action="<?php echo base_url() ?>auth/forgot" method="post">
                                <div class="form-group mb-2">
                                    <label class="text-bold-600" for="exampleInputEmailPhone1">Email Address</label>
                                    <input type="text" name="forgot_email" class="form-control" id="exampleInputEmailPhone1"
                                        placeholder="Email Address"></div>
                                <button type="submit" name="forgot_pwd" value="forgot_pwd" class="btn btn-primary glow position-relative w-100">SEND
                                    PASSWORD<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                            </form>
                            <div class="text-center mb-2"><a href="<?php echo base_url() ?>auth/login"><small class="text-muted">I
                                        remembered my
                                        password</small></a></div>

                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center">
                    <img class="img-fluid" src="<?php echo base_url(); ?>assets/app-assets/images/pages/forgot-password.png"
                        alt="branding logo" width="300">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- forgot password ends -->

        </div>
      </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <!-- <script src="<?php #echo base_url(); ?>assets/app-assets/vendors/js/vendors.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/configs/vertical-menu-light.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/app-menu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/app.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/components.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

    <script type="text/javascript">
    // Default Configuration
        $(document).ready(function() {
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': false,
                'progressBar': false,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            }
        });

        var success_msg = "<?php echo $this->session->flashdata('succ_msg'); ?>";

            var error_msg = "<?php echo $this->session->flashdata('err_msg'); ?>";

            if(success_msg.length > 0)
            {
                toastr.success(success_msg);
            }
            else if(error_msg.length > 0)
            {
                toastr.error(error_msg);
            }

        // Toast Type
        // toastr.error('You clicked Success toast');
        
    </script>

  </body>
  <!-- END: Body-->

<!-- Mirrored from www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/html/ltr/vertical-menu-template/auth-forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Sep 2021 17:38:51 GMT -->
</html>