<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$sql_customer = "SELECT * FROM customer_master ORDER BY customer_name ASC";	
	$result_customer = $mysqli->query($sql_customer);

	$sql_item = "SELECT * FROM item_master ORDER BY item_name ASC";	
	$result_item = $mysqli->query($sql_item);

	//$sql_bill = "SELECT * FROM bill_details ORDER BY bill_id DESC";	
	$start_date_time = date('Y-m-d').' 00:00:00';
    $end_date_time = date('Y-m-d').' 23:59:59';

    $sql_bill = "SELECT * FROM bill_details WHERE create_date >= '" .$start_date_time. "' AND create_date <= '" .$end_date_time. "' ORDER BY bill_id DESC  LIMIT 0, 10";
	$result_bill = mysqli_query($con, $sql_bill);
	//$result_bill = $mysqli->query($sql_bill);
?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#">Bill Details</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-12">							
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openBillModal('0')">New Bill</a></div>
								
								<div class="card mb-4">
									<div class="card-header">
										<i class="fas fa-table mr-1"></i>
										<?=$title?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="todaysBill" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>Bill Number</th>
														<th>Customer Name</th>
														<th>Phone Number</th>
														<th>Total Fine</th>
														<th>Total Jama</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Bill Number</th>
														<th>Customer Name</th>
														<th>Phone Number</th>
														<th>Total Fine</th>
														<th>Total Jama</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												if(mysqli_num_rows($result_bill) > 0){
													$i = 0;
												while ($row_bill = $result_bill->fetch_array()){ 
													$i++;
													$bill_id = $row_bill['bill_id'];
													$bill_description = json_decode(base64_decode($row_bill['bill_description']));
												?>
													<tr id="bill_row_<?=$bill_id?>">
														<td><?=$i?></td>
														<td><?=$bill_description->customer_name?></td>
														<td><?=$bill_description->phone_number?></td>
														<td style="text-align: right;"><?=round($bill_description->fineItemsTotalSubTotal, 3)?></td>
														<td style="text-align: right;"><?=round($bill_description->jamaItemsSubTotal, 3)?></td>
														<td>
															<a class="btn btn-primary" onclick="openBillModal('<?=$bill_id?>')">Update</a>

															<a class="btn btn-danger" id="saveLoanProd_<?=$bill_id?>" onclick="deleteBill(<?=$bill_id?>)">Delete</a>

															<a href="pages/bill_printer/bill_pdf.php?bill_id=<?php echo $bill_id; ?>" target="_blank" class="btn btn-primary" >Print</a>

															<!-- <form name="form1" id="form1" target="_blank" method="POST" action="pages/bill_printer/bill_pdf.php" style="float: left;padding-right: 5px;">
															<input type="hidden" name="bill_id_print_<?php echo $bill_id; ?>" value="<?php echo $bill_id; ?>">
															<input class="btn btn-primary" type="submit" name="print_cb" value="Print">
															</form> -->

														</td>
													</tr>
													<?php } 
													}else{?>												
														</tr><td colspan='6'>No record found</td></tr>
													<?php } ?>
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
				<div id="myModalCustomer" class="modal">
				  <!-- Modal content -->
				  <div class="modal-content-bill">
					<div class="modal-header">
						<h3>Create/Update Bill</h3>
					  <span class="close" onClick="closeCustomerModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>

					<div class="form-row">
                        <div class="col-md-3">
							<div class="form-group">
								<label for="exampleInputEmail1">Customer Name*</label>
								<select class="form-control" id="bill_customer_id">
									<option selected value="0">Select Customer</option>
									<?php
									while ($row_customer = $result_customer->fetch_array()){ 
									?>
									<option value="<?=$row_customer['customer_id']?>" metal_jama="<?=$row_customer['metal_jama']?>" metal_due="<?=$row_customer['metal_due']?>" cash_jama="<?=$row_customer['cash_jama']?>" cash_due="<?=$row_customer['cash_due']?>" phone_number="<?=$row_customer['phone_number']?>"><?php echo $row_customer['customer_name'].'('.$row_customer['phone_number'].')'; ?></option>
									<?php } ?>
								</select>
								<small id="customer_id_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1" id="guestUserPhoneLabel">Guest Customer Ph. No.</label>
								<input type="number" class="form-control text-right" id="guestUserPhone" placeholder="Guest Customer Ph. No.">
								<small id="guestUserPhone_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1" id="metal_label">Old balance(Metal)</label>
								<input type="number" class="form-control text-right" id="old_balance_metal" placeholder="Old balance(Metal)" readonly="readonly">
								<small id="old_balance_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1" id="cash_label">Old balance(Cash)</label>
								<input type="number" class="form-control text-right" id="old_balance_cash" placeholder="Old balance(Cash)" readonly="readonly">
								<small id="old_balance_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>


					<div class="form-row">
                        <div class="col-md-3">
							<div class="form-group">
								<label for="exampleInputEmail1">Item*</label>
								<select class="form-control" id="bill_item_id">
									<option value="0" selected>Select Item</option>
									<?php
									while ($row_item = $result_item->fetch_array()){ 
									?>
									<option value="<?=$row_item['item_id']?>" first_tunch="<?=$row_item['first_tunch']?>" second_tunch="<?=$row_item['second_tunch']?>" item_name="<?=$row_item['item_name']?>"><?=$row_item['item_name']?> (<?=$row_item['first_tunch']?> + <?=$row_item['second_tunch']?>)</option>
									<?php } ?>
								</select>
								<small id="item_id_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Serial No*</label>
								<input type="number" class="form-control text-right" id="bill_stock_serial_no" placeholder="Serial No" step="1">
								<small id="bill_stock_serial_no_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Weight*</label>
								<input type="number" class="form-control text-right" id="item_weight" placeholder="Weight" step="0.001">
								<input type="hidden" id="raw_material_price" value="0.00">
								<small id="item_weight_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="exampleInputEmail1">1st Tunch</label>
								<input type="number" class="form-control text-right" id="first_tunch" placeholder="First Tunch" step="0.001">
								<small id="first_tunch_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="exampleInputEmail1">2nd Tunch</label>
								<input type="number" class="form-control text-right" id="second_tunch" placeholder="Second Tunch" step="0.001">
								<small id="second_tunch_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Fine</label>
								<input type="number" class="form-control text-right" id="item_fine" placeholder="Fine" readonly="readonly">
								<small id="item_fine_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<button type="button" class="btn btn-primary btn-sm" id="addBillItem">Add</button>
					<!-- Item Add Part End -->

					<!-- Table Start -->
					<table class="table table-sm" id="billedItem">
						<thead>
							<tr>
							<th scope="col">Item</th>
							<th scope="col" class="text-right">Weight</th>
							<th scope="col" class="text-right">First Tunch</th>
							<th scope="col" class="text-right">Second Tunch</th>
							<th scope="col" class="text-right">Fine</th>
							<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody id="tbody_billedItem">
							<!-- <tr>
								<td>92T Chain (92.00 + 2.50)</td>
								<td class="text-right">35.260</td>
								<td class="text-right">92.00</td>
								<td class="text-right">2.50</td>
								<td class="text-right">33.321</td>
								<td>
									<button type="button" class="btn btn-primary btn-sm">Edit</button>
									<button type="button" class="btn btn-secondary btn-sm">Delete</button>
								</td>
							</tr> -->
						</tbody>
						<thead>
							<tr>
							<th scope="col" colspan="4">Sub Total</th>
							<th scope="col" class="text-right" id="fineItemsSubTotal">00.000</th>
							<th scope="col"></th>
							</tr>
						</thead>
						<thead>
							<tr>
							<th scope="col" colspan="4">Total (Sub Total &#247; 99.50)</th>
							<th scope="col" class="text-right" id="fineItemsTotalSubTotal">00.000</th>
							<th scope="col"></th>
							</tr>
						</thead>
						</table>
					<!-- table End -->

					<!-- Jama Detail part Start -->
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Jama Details</label>
								<input type="text" class="form-control" id="jama_item" placeholder="Jama Details" value="GOLD" readonly="readonly">
								<small id="jama_item_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Weight</label>
								<input type="number" class="form-control text-right" id="jama_item_weight" placeholder="Weight" step="0.001">
								<small id="jama_item_weight_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group mt-4">
								<button type="button" class="btn btn-primary btn-sm" id="adJamaDetail">Add</button>	
							</div>
						</div>

					</div>


					<!-- Jama Table Start -->
					<table class="table table-sm" id="jamaDetails">
						<thead>
							<tr>
							<th scope="col" colspan="5">Item</th>
							<th scope="col" class="text-right">Weight</th>
							<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody id="tbody_jamaDetails">
							<!-- <tr>
								<td colspan="5">BREAD</td>
								<td class="text-right">25.570</td>
								<td>
									<button type="button" class="btn btn-primary btn-sm">Edit</button>
									<button type="button" class="btn btn-secondary btn-sm">Delete</button>
								</td>
							</tr> -->
						</tbody>
						<thead>
							<tr>
							<th scope="col" colspan="5">Sub Total</th>
							<th scope="col" class="text-right" id="jamaItemsSubTotal">00.000</th>
							<th scope="col"> </th>
							</tr>
						</thead>
						<thead>
							<tr>
							<th scope="col" colspan="5">Total</th>
							<th scope="col" class="text-right" id="netMetalBalance">00.000/- (Due)</th>
							<th scope="col"> </th>
							</tr>
						</thead>
						</table>
					<!-- Jama Table End -->

					<!-- Jama Detail part End -->

					<div class="form-row">						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Payment Type</label></br>								
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="payment_type" id="cash" value="cash">
									<label class="form-check-label" for="cash">Cash</label>
								</div>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="payment_type" id="due" value="due">
									<label class="form-check-label" for="due">Due</label>
								</div>
							</div>
						</div>
						
						<div class="col-md-2" id="rateBlock" style="display: none;">
							<div class="form-group">
								<label for="exampleInputEmail1">Rate/gm.</label>
								<input type="number" class="form-control text-right" id="ratePerGm" placeholder="Rate/gm." >
								<small id="ratePerGm_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2" id="totalCashBlock" style="display: none;">
							<div class="form-group">
								<label for="exampleInputEmail1">Total cash</label>
								<input type="number" class="form-control text-right" id="totalCash" placeholder="Total cash" readonly>
								<small id="totalCash_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2" id="amountJamaBlock" style="display: none;">
							<div class="form-group">
								<label for="exampleInputEmail1">Rate/gm.</label>
								<input type="number" class="form-control text-right" id="amountJama" placeholder="0.00" >
								<small id="amountJama_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group mt-4">
								<input type="hidden" name="current_bill_id" id="current_bill_id" value="0">
								<input type="hidden" name="oldDue" id="oldDue" value="0">
								<input type="hidden" name="oldJama" id="oldJama" value="0">
								<button type="button" class="btn btn-primary" id="createFinalBill">Create Final Bill</button>	
							</div>
						</div>

					</div>

					</form>	

					</div>
					<div class="modal-footer">
					  <!-- <h5>Please check all the details above before the final bill </h5> -->
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				<?php include('common/footer.php'); ?>