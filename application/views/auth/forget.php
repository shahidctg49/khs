<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Housing Society Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg bg-gradient">

            <div class="account-pages pt-5 mt-5 mb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card bg-pattern">
    
                                <div class="card-body p-4">
                                    
                                    <div class="text-center m-auto">
                                        <a href="index.html">
                                            <span><img src="<?= base_url('assets/images/logo-dark.png') ?>" alt="" height="20"></span>
                                        </a>
                                        <p class="text-muted sub-header mb-4 mt-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                                    </div>
									<?php if($this->session->flashdata('message')){ ?>
												<?= $this->session->flashdata('message') ?>
											<?php } ?>
                                    <?= form_open('forget') ?>
    
                                        <div class="form-group mb-3">
                                            <label for="emailaddress">Email address</label>
                                            <input class="form-control" type="email" id="emailaddress" name="email" placeholder="john@deo.com" value="<?= set_value('email','')?>" >
											<?= form_error('email') ?>
										</div>
    
                                        <div class="form-group mb-0 text-center">
                                            <button class="btn btn-gradient btn-block" type="submit"> Reset Password </button>
                                        </div>
    
                                    </form>

                                    <div class="row mt-4">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted mb-0">Back to <a href="<?= base_url('login') ?>" class="text-dark ml-1"><b>Sign In</b></a></p>
                                            </div>
                                        </div>

    
                                </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->
    
                          
    
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end page -->
    

        <!-- Vendor js -->
        <script src="<?= base_url('assets/js/vendor.min.js') ?>"></script>

        <!-- App js -->
        <script src="<?= base_url('assets/js/app.min.js') ?>"></script>
        
    </body>
</html>








