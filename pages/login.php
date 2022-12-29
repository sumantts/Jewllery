<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Jewellery | Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="assets/js/all.min.js" crossorigin="anonymous"></script>
		<style>
			.modal {
				display:    none;
				position:   fixed;
				z-index:    1000;
				top:        0;
				left:       0;
				height:     100%;
				width:      100%;
				background: rgba( 255, 255, 255, .5 ) 
							url('assets/img/FhHRx.gif')
							50% 50% 
							no-repeat;
			}

			/* When the body has the loading class, we turn
			   the scrollbar off with overflow:hidden */
			body.loading .modal {
				overflow: hidden;   
			}

			/* Anytime the body has the loading class, our
			   modal element will be visible */
			body.loading .modal {
				display: block;
			}
	</style>
    </head>
	<?php
	  if(isset($_SESSION["SocietyId"])){header('location:?p=dashboard');}
	  if(isset($_GET["out"]) == "ok"){
		  //LogOut Entry
			$Usr_Id = $_SESSION["UsrId"];
			$App_SesId = $_SESSION["App_SesId"];
			$Db_SesId = $_SESSION["Ret_DbSesId"];			
		  session_unset();
		  header("location:?p=login");
	  }
	  ?>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header" style="text-align: center;">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
									
                                    </div>
                                    <div class="card-body">
									<span class="text-warning" id="error_text"></span>
                                        <form name="login" id="login" method="post" autocomplete="off">
                                            <div class="form-group">
                                                <label class="small mb-1" for="username">Username</label>
                                                <input class="form-control" id="username" name="username" type="text" placeholder="Enter Username" />
												<span class="col-form-label  text-danger" id="username_error" style="font-size: 12px;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Enter password" />
												<span class="col-form-label  text-danger" id="password_error" style="font-size: 12px;"></span>
                                            </div>
                                            <!--<div class="form-group">
                                                <label class="small mb-1" for="captcha">Captcha</label>
                                                <input class="form-control" id="cpatchaTextBox" name="captcha" type="text" placeholder="Enter Captcha" />
												<span class="col-form-label  text-danger" id="captcha_error" style="font-size: 12px;"></span>
                                            </div>
                                            <div class="form-group">
												<div id="captcha"></div>
                                                <a class="btn btn-primary" onclick="createCaptcha()">Refresh</a>
                                               <a class="btn btn-primary" id="login_btn" style="float: right;">Login</a>
                                            </div>-->
                                            <!--<div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>-->
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <!--<a class="small" href="#">Forgot Password?</a>-->
                                                <a class="btn btn-primary" id="login_btn">Login</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small">@copy <?=date('Y')?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-2 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; WBSRLM <?=date('Y')?></div>
                            <div>
                                <a href="#">All Rights Reserved</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
		<div class="modal"><!-- Place at bottom of page Loading--></div>
        <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>-->
		<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
        <script src="js/jquery-3.6.0.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
		<script src="js/function.js"></script>
    </body>
</html>
