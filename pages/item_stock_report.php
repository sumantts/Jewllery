<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$sql = "SELECT * FROM item_master ORDER BY item_id DESC";	
	$result = $mysqli->query($sql);
	$last_serial_no = 0000;

	if(isset($_POST['stock_item_id_report'])){
		
	}else{
		$stock_item_id = 0;
	}

?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#">Reports</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-12">
							<!-- Stock Entry Panel -->
							<div class="col-lg-12">
							<form action="pages/bill_printer/item_stock_pdf.php?stock_item_id=<?=$_POST['stock_item_id_report']?>" method="GET" target="_blank" name="itemstock_form" id="itemstock_form">
								<div class="form-row">
									<div class="form-group col-md-4">
									<label for="inputState">Item*</label>
									<select id="stock_item_id_report" class="form-control" name="stock_item_id_report">
										<option value="0" <?php if($stock_item_id == 0){?> selected <?php } ?>>Choose Item</option>
										<?php
										while ($row = $result->fetch_array()){ 
										?>
										<option value="<?=$row['item_id']?>" <?php if($stock_item_id == $row['item_id']){?> selected <?php } ?>> <?=$row['item_name']?> </option>
										<?php } ?>
									</select>
									<small id="stock_item_id_error" class="form-text text-muted"></small>
									</div>

									<div class="form-group col-md-2">
									<label for="start_date_report">Start Date* </label>
									<input type="date" class="form-control" id="start_date_report" name="start_date_report" >
									<small id="start_date_report_error" class="form-text text-muted"></small>
									</div>

									<div class="form-group col-md-2">
									<label for="end_date_report">End Date*</label>
									<input type="date" class="form-control" id="end_date_report" name="end_date_report" >
									<small id="end_date_report_error" class="form-text text-muted"></small>
									</div>
									
									<div class="form-group col-md-2" style="margin-top: 25px;">	
										<label for="inputState">&nbsp;</label>										
										<button type="submit" class="btn btn-primary" id="viewStockReport" name="viewStockReport">View Report</button>
										<small id="viewStockReport_error" class="form-text text-muted"></small>
								
									</div>	

									<!-- <div class="form-group col-md-2" style="margin-top: 25px;">	
										<label for="inputState">&nbsp;</label>					
										<?php
										//if(isset($_POST['stock_item_id'])){
										?>									
										<a href="pages/bill_printer/item_stock_pdf.php?stock_item_id=<?=$_POST['stock_item_id']?>" class="btn btn-primary" target="_blank" id="generateStockReport" name="generateStockReport">Report</a>
										<?php 
										//} 
										?>
									</div> -->

								</div>
								</form>							
							</div>								
								
                            </div>
                        </div>
                    </div>
                </main>
				
				<!-- The Modal -->
				<div id="myModal" class="modal">
				  <!-- Modal content -->
				  <div class="modal-content">
					<div class="modal-header">
						<h3>Add/Update Item</h3>
					  <span class="close" onClick="closeItemModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Item Name</label>
								<input type="hidden" class="form-control" id="item_id" value="0">
								<input type="text" class="form-control" id="item_name" placeholder="Item Name">
								<small id="item_name_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">First Tunch</label>
								<input type="number" class="form-control" id="first_tunch" placeholder="First Tunch">
								<small id="first_tunch_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Weastage</label>
								<input type="number" class="form-control" id="second_tunch" placeholder="Second Tunch" value="00.00">
								<small id="second_tunch_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Total Tunch</label>
								<input type="number" class="form-control" id="total_tunch" placeholder="Total Tunch" readonly="readonly">
								<small id="total_tunch_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>
					
					<button type="button" class="btn btn-primary" id="saveItem">OK</button>	
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				<?php include('common/footer.php'); ?>