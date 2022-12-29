<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$sql = "SELECT * FROM item_master ORDER BY item_id DESC";	
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
							
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openItemModal()">Add Items</a></div>
								
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
														<th>Item Name</th>
														<th>First Tunch</th>
														<th>Second Tunch</th>
														<th>Total Tunch</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Item Name</th>
														<th>First Tunch</th>
														<th>Second Tunch</th>
														<th>Total Tunch</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												while ($row = $result->fetch_array()){ 
												?>
													<tr id="item_id_<?=$row['item_id']?>">
														<td><?=$row['item_name']?></td>
														<td style="text-align: right;"><?=$row['first_tunch']?></td>
														<td style="text-align: right;"><?=$row['second_tunch']?></td>
														<td style="text-align: right;"><?=$row['total_tunch']?></td>
														<td>
														<a class="btn btn-primary" onclick="updateItemModal('<?=$row['item_id']?>')">Update</a>
														<a class="btn btn-danger" onclick="deleteItem('<?=$row['item_id']?>')">Delete</a>
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