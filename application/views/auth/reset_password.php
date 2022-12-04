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
        <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">

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
                                    
                                    <div class="text-center w-75 m-auto">
                                        <a href="index.html">
                                            <span><img src="<?= base_url('assets/images/logo-dark.png')?>" alt="" height="18"></span>
                                        </a>
                                        <h5 class="text-uppercase text-center font-bold mt-4">Reset Password</h5>
                                    </div>
									<?php if($this->session->flashdata('message')){ ?>
												<?= $this->session->flashdata('message') ?>
											<?php } ?>
											<?= form_open('changepassword/'.$key) ?>
    
									<div class="form-group">
                                            <label for="password">Password</label>
                                            <input class="form-control" type="password" required id="password" placeholder="Enter your password" name="password">
											<?= form_error('password') ?>
										
										</div>
                                        <div class="form-group">
                                            <label for="password">confirm Password</label>
                                            <input class="form-control" type="password" required id="password" placeholder="confirm your password" name="repassword">
											<?= form_error('repassword') ?>
                                        </div>
                                        
                                        <div class="form-group mb-0 text-center">
                                            <button class="btn btn-gradient btn-block" type="submit"> Reset </button>
                                        </div>
    
                                    </form>
    
                                    <div class="row mt-4">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted mb-0">Don't have an account? <a href="<?= base_url('register') ?>" class="text-dark ml-1"><b>Sign Up</b></a></p>
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




























