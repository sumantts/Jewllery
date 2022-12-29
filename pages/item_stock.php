<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$sql = "SELECT * FROM item_master ORDER BY item_id DESC";	
	$result = $mysqli->query($sql);
	$last_serial_no = 0000;

	if(isset($_POST['stock_item_id'])){
		$stock_item_id = $_POST['stock_item_id'];	
		$sql_last_serial = "SELECT MAX(stock_serial_no) AS last_serial_no FROM item_stock_master WHERE item_id = '".$stock_item_id."' ";
		$res_last_serial = $mysqli->query($sql_last_serial);
		if(mysqli_num_rows($res_last_serial) > 0){
			$row_last_serial = $res_last_serial->fetch_array();
			$last_serial_no1 = $row_last_serial['last_serial_no'];
			if($last_serial_no1 > 0){
				$last_serial_no = $last_serial_no1 + 1;
			}
		}
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
                            <li class="breadcrumb-item"><a href="#">Master Entry</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-12">
							<!-- Stock Entry Panel -->
							<div class="col-lg-12">
							<form action="?p=item_stock" method="POST" name="itemstock_form" id="itemstock_form">
								<div class="form-row">
									<div class="form-group col-md-4">
									<label for="inputState">Item*</label>
									<select id="stock_item_id" class="form-control" name="stock_item_id">
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
									<label for="stock_serial_no">Serial No* </label>
									<input type="text" class="form-control" id="stock_serial_no" name="stock_serial_no" value="<?=$last_serial_no?>">
									<small id="stock_serial_no_error" class="form-text text-muted"></small>
									</div>

									<div class="form-group col-md-2">
									<label for="stock_weight">Weight*</label>
									<input type="number" class="form-control" id="stock_weight" name="stock_weight" value="">
									<small id="stock_weight_error" class="form-text text-muted"></small>
									</div>

									<div class="form-group col-md-2">
									<label for="stock_weight">Raw Material Price</label>
									<input type="number" class="form-control" id="raw_material_price" name="raw_material_price" value="">
									<small id="raw_material_price_error" class="form-text text-muted"></small>
									</div>

									<div class="form-group col-md-2" style="margin-top: 25px;">	
										<label for="inputState">&nbsp;</label>										
										<button type="button" class="btn btn-primary" id="addItemStock" name="addItemStock">Add</button>
										<small id="addItemStock_error" class="form-text text-muted"></small>
								
									</div>	
								</div>
								</form>							
							</div>

								

							<!-- Stock Entry Panel end -->
							
								<!-- <div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openItemModal()">Add Items</a></div> -->
								
								<div class="card mb-4">
									<div class="card-header">
										<i class="fas fa-table mr-1"></i>
										<?=$title?>

										<?php
										if(isset($_POST['stock_item_id'])){
										?>									
										<a href="pages/bill_printer/item_stock_pdf.php?stock_item_id=<?=$_POST['stock_item_id']?>" class="btn btn-primary" target="_blank" id="generateStockReport" name="generateStockReport">Report</a>
										<?php } ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>SL #</th>
														<th>Item Name</th>
														<th>Serial</br> Number</th>
														<th>Weight</th>
														<th>Raw Material</br> Price</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>SL #</th>
														<th>Item Name</th>
														<th>Serial</br> Number</th>
														<th>Weight</th>
														<th>Raw Material</br> Price</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												if(isset($_POST['stock_item_id'])){
													if($stock_item_id > 0){
														$sql_stock = "SELECT item_stock_master.stock_id, item_stock_master.item_id, item_stock_master.stock_serial_no, item_stock_master.stock_weight, item_stock_master.raw_material_price, item_stock_master.stock_status, item_master.item_name FROM item_stock_master JOIN item_master ON item_stock_master.item_id = item_master.item_id WHERE item_stock_master.item_id = '".$stock_item_id."'";	
														$result_stock = $mysqli->query($sql_stock);	
													
													if(mysqli_num_rows($result_stock) > 0){
														$i = 1;
														while ($row_stock = $result_stock->fetch_array()){ 
													?>
															<tr id="stock_id_<?=$row_stock['stock_id']?>">
																<td><?=$i?></td>
																<td><?=$row_stock['item_name']?></td>
																
																<td style="text-align: right;">
																<span id="stock_serial_no_txt_<?=$row_stock['stock_id']?>">
																<?=$row_stock['stock_serial_no']?>
																</span>

																<input type="hidden" class="form-control" id="stock_serial_no_<?=$row_stock['stock_id']?>" name="stock_serial_no_<?=$row_stock['stock_id']?>" value="<?=$row_stock['stock_serial_no']?>">

																</td>

																<td style="text-align: right;">
																	<span id="stock_weight_txt_<?=$row_stock['stock_id']?>">
																	<?=$row_stock['stock_weight']?>
																	</span>

																	<input type="hidden" class="form-control" id="stock_weight_<?=$row_stock['stock_id']?>" name="stock_weight_<?=$row_stock['stock_id']?>" value="<?=$row_stock['stock_weight']?>">
																																	
																</td>

																<td style="text-align: right;">
																	<span id="raw_material_price_txt_<?=$row_stock['stock_id']?>">
																	<?=$row_stock['raw_material_price']?>

																	<input type="hidden" class="form-control" id="raw_material_price_<?=$row_stock['stock_id']?>" name="raw_material_price_<?=$row_stock['stock_id']?>" value="<?=$row_stock['raw_material_price']?>">
																</td>
																
																<td style="text-align: right;">
																<?php
																if($row_stock['stock_status'] == 1){ 
																	echo "Available";
																}else{
																	echo "Sold Out";
																}
																?>
																</td>
																<td>
																<?php
																if($row_stock['stock_status'] == 1){ 
																?>
																	<a class="btn btn-primary" id="edit_<?=$row_stock['stock_id']?>" onclick="editItemStock('<?=$row_stock['stock_id']?>')">Edit</a> 
																	<a style="display: none;" id="update_<?=$row_stock['stock_id']?>" class="btn btn-primary" onclick="updateItemStock('<?=$row_stock['stock_id']?>')">Update</a>
																	
																	<a class="btn btn-danger" onclick="deleteItemStock('<?=$row_stock['stock_id']?>')">Delete</a>
																<?php
																}
																?>
																</td>
															</tr>
													<?php 
														$i++;
													} //end while
													}//end num rows
												}
												}else{
													?>
													<tr><td colspan="5">No data Available</td></tr>
													<?php
												}
												?>
												</tbody>
											</table>
										</div>
									</div>
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