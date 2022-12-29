<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$sql = "SELECT * FROM customer_master";	
	$result = $mysqli->query($sql);
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
							
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openCustomerModal()">Add Customer</a></div>
								
								<div class="card mb-4">
									<div class="card-header">
										<i class="fas fa-table mr-1"></i>
										<?=$title?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>Name</th>
														<th>Phone Number</th>
														<th>Metal Jama</th>
														<th>Metal Due</th>
														<th>Cash Jama</th>
														<th>Cash Due</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Name</th>
														<th>Phone Number</th>
														<th>Metal Jama</th>
														<th>Metal Due</th>
														<th>Cash Jama</th>
														<th>Cash Due</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												while ($row = $result->fetch_array()){ 
												?>
													<tr id="customer_id_<?=$row['customer_id']?>">
														<td><?=$row['customer_name']?></td>
														<td><?=$row['phone_number']?></td>
														<td style="text-align: right;"><?=$row['metal_jama']?></td>
														<td style="text-align: right;"><?=$row['metal_due']?></td>
														<td style="text-align: right;"><?=$row['cash_jama']?></td>
														<td style="text-align: right;"><?=$row['cash_due']?></td>
														<td>
														<a class="btn btn-primary" onclick="updateCustomerModal('<?=$row['customer_id']?>')">Update</a>
														<a class="btn btn-danger" onclick="deleteCustomer('<?=$row['customer_id']?>')">Delete</a>
														<a class="btn btn-primary" onclick="miniStatement('<?=$row['customer_id']?>')">Mini. Slip</a>
														</td>
													</tr>
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
				  <div class="modal-content">
					<div class="modal-header">
						<h3>Add/Update Customer</h3>
					  <span class="close" onClick="closeCustomerModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Customer Name</label>
								<input type="hidden" class="form-control" id="customer_id" value="0">
								<input type="text" class="form-control" id="customer_name" placeholder="Customer Name" value="Guest Customer">
								<small id="customer_name_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Phone Number</label>
								<input type="number" class="form-control" id="phone_number" placeholder="Phone Number">
								<small id="phone_number_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>
					
					<button type="button" class="btn btn-primary" id="saveCustomer">OK</button>	
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->

				<!-- The Mini statement Modal -->
				<div id="miniSlip" class="modal">
				  <!-- Modal content -->
				  <div class="modal-content">
					<div class="modal-header">
						<h3>Mini Statement</h3>
					  <span class="close" onClick="closeMiniSlipModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						<table class="table table-sm">
							<thead>
								<tr>
								<th scope="col">#</th>
								<th scope="col">Order No.</th>
								<th scope="col" style="text-align: right;">Fine(After 99.50)</th>
								<th scope="col" style="text-align: right;">Jama</th>
								<th scope="col" style="text-align: right;">Bill Summary</th>
								<th scope="col" style="text-align: right;">Due</th>
								<th scope="col" style="text-align: right;">Cash</th>
								<th scope="col" >Create Date</th>
								</tr>
							</thead>
							<tbody id="tbody_ministatement">
								
								
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				<?php include('common/footer.php'); ?>