<!--<button id="myBtn">Open Modal</button>-->
                <!--<footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"><strong>Name of the CLF: <?=$_SESSION["SocietyNm"]?></strong></div>
                            <div>
                                <a href="#">Developed by: Bagnan I Mahila Bikash Co-operative Credit Society Ltd </a>
                            </div>
                        </div>
                    </div>
                </footer>-->
            </div>
        </div>
		
		<style>
			.loading_modal {
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
			body.loading .loading_modal {
				overflow: hidden;   
			}

			/* Anytime the body has the loading class, our
			   loading_modal element will be visible */
			body.loading .loading_modal {
				display: block;
			}
	</style>
		<div class="loading_modal"><!-- Place at bottom of page Loading--></div>
		
		<input type="hidden" id="login_id" value="<?=$_SESSION["login_id"]?>">
		
		<!--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>-->
		<!-- <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script> Working with internet connection -->
		<script src="js/jquery-3.6.0.js" crossorigin="anonymous"></script>



        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>-->		
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>      
		<script src="js/scripts.js"></script>
		
        <!--<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>-->
		<script src="js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <!--<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>-->
        <script src="js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        
		<script src="assets/demo/datatables-demo.js"></script>
		<script src="js/function.js"></script>
    </body>
</html>
