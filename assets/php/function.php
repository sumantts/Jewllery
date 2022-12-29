<?php
	include('sql_conn.php');
	$fn = '';
	if(isset($_POST["fn"])){
	$fn = $_POST["fn"];
	}
	
	//Login function
	if($fn == 'doLogin'){
		$return_result = array();
		$username = $_POST["username"];
		$password = $_POST["password"];
		$status = true;	
		$login_id = '';
	
		$sql = "SELECT * FROM login WHERE username = '".$username."' && password = '".$password."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$login_id = $row['login_id'];			
			$username = $row['username'];
			$_SESSION["username"] = $username;
		} else {
			$status = false;
		}
		$mysqli->close();
					
		$_SESSION["login_id"] = $login_id;
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function doLogin
	
	//Save Item function
	if($fn == 'saveItem'){
		$return_result = array();
		$item_id = $_POST["item_id"];
		$item_name = $_POST["item_name"];
		$first_tunch = $_POST["first_tunch"];
		$second_tunch = $_POST["second_tunch"];
		$total_tunch = $_POST["total_tunch"];

		$status = true;	

		if ($item_id > 0) {
			//update
			$sql_update = "UPDATE item_master SET item_name = '".$item_name."', first_tunch = '".$first_tunch."', second_tunch = '".$second_tunch."', total_tunch = '".$total_tunch."' WHERE item_id = '" .$item_id. "' ";
			$mysqli->query($sql_update);
		} else {
			//Insert
			$sql_insert = "INSERT INTO item_master (item_name, first_tunch, second_tunch, total_tunch) VALUES('".$item_name."', '".$first_tunch."', '".$second_tunch."', '".$total_tunch."')";
			$result_insert = $mysqli->query($sql_insert);
			$item_id = $mysqli->insert_id;
		}
		$mysqli->close();

		$return_result['item_id'] = $item_id;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveItem
	
	//Get Item
	if($fn == 'getItem'){
		$return_result = array();
		$item_id = $_POST["item_id"];
		$status = true;	
	
		$sql = "SELECT * FROM item_master WHERE item_id = '".$item_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$item_id = $row['item_id'];
			$item_name = $row['item_name'];
			$first_tunch = $row['first_tunch'];
			$second_tunch = $row['second_tunch'];
			$total_tunch = $row['total_tunch'];
		}
		
		$mysqli->close();

		$return_result['item_id'] = $item_id;
		$return_result['item_name'] = $item_name;
		$return_result['first_tunch'] = $first_tunch;
		$return_result['second_tunch'] = $second_tunch;
		$return_result['total_tunch'] = $total_tunch;
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function getItem

	//Delete Item function
	if($fn == 'deleteItem'){
		$return_result = array();
		$item_id = $_POST["item_id"];
		$status = true;	
	
		$sql = "DELETE FROM item_master WHERE item_id = '".$item_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function deleteItem

	//////////////////////////// END ITEM PART ///////////////////////////////////////


	/////////////////////////// START CUSTOMER PART //////////////////////////////////	
	//Save Customer function
	if($fn == 'saveCustomer'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$customer_name = $_POST["customer_name"];
		$phone_number = $_POST["phone_number"];

		$status = true;	

		if ($customer_id > 0) {
			//update
			$sql_update = "UPDATE customer_master SET customer_name = '".$customer_name."', phone_number = '".$phone_number."' WHERE customer_id = '" .$customer_id. "' ";
			$mysqli->query($sql_update);

			$sql = "SELECT * FROM customer_master WHERE customer_id = '".$customer_id."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_array();
				$return_result['metal_jama'] = $row['metal_jama'];
				$return_result['metal_due'] = $row['metal_due'];
				$return_result['cash_jama'] = $row['cash_jama'];
				$return_result['cash_due'] = $row['cash_due'];
			}
		} else {
			//Insert
			$sql_insert = "INSERT INTO customer_master (customer_name, phone_number) VALUES('".$customer_name."', '".$phone_number."')";
			$result_insert = $mysqli->query($sql_insert);
			$customer_id = $mysqli->insert_id;
		}
		$mysqli->close();

		$return_result['customer_id'] = $customer_id;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveCustomer
	
	//Get Customer
	if($fn == 'getCustomer'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$status = true;	
	
		$sql = "SELECT * FROM customer_master WHERE customer_id = '".$customer_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$return_result['customer_id'] = $row['customer_id'];
			$return_result['customer_name'] = $row['customer_name'];
			$return_result['phone_number'] = $row['phone_number'];
		}
		
		$mysqli->close();
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function getCustomer

	//Delete Item function
	if($fn == 'deleteCustomer'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$status = true;	
	
		$sql = "DELETE FROM customer_master WHERE customer_id = '".$customer_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function deleteCustomer

	//miniStatement start
	if($fn == 'miniStatement'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$status = true;	
	
		$sql = "SELECT * FROM bill_details WHERE customer_id = '".$customer_id."' ORDER BY create_date DESC LIMIT 3
		";
		$result = $mysqli->query($sql);

		$i = 0;

		if ($result->num_rows > 0) {
			$subTotalfineItemsTotalSubTotal = 0;
			$subTotaljamaItemsSubTotal = 0;
			$subTotalnetMetalBalance = 0;
			$subTotaltotalCash = 0; 

			$miniStatement = array();

			while ($row_bill = $result->fetch_array()){ 
				$miniStatementObj = new stdClass();
				$i++;
				$bill_id = $row_bill['bill_id'];
				$bill_description = json_decode(base64_decode($row_bill['bill_description']));
				
				$miniStatementObj->i = $i;
				$miniStatementObj->billId = $bill_description->billId;
				$miniStatementObj->fineItemsTotalSubTotal = $bill_description->fineItemsTotalSubTotal;
				$miniStatementObj->jamaItemsSubTotal = $bill_description->jamaItemsSubTotal;
				$miniStatementObj->netMetalBalance = $bill_description->netMetalBalance;
				$miniStatementObj->netMetalBalance = $bill_description->netMetalBalance;
				$miniStatementObj->totalCash = $bill_description->totalCash;
				$miniStatementObj->create_date = date('d-m-Y', strtotime($row_bill['create_date']));

				array_push($miniStatement, $miniStatementObj);

				$subTotalfineItemsTotalSubTotal = ($subTotalfineItemsTotalSubTotal + $bill_description->fineItemsTotalSubTotal);
				$subTotaljamaItemsSubTotal = ($subTotaljamaItemsSubTotal + $bill_description->jamaItemsSubTotal);
				$subTotalnetMetalBalance = ($subTotalnetMetalBalance + $bill_description->netMetalBalance);
				$subTotaltotalCash = ($subTotaltotalCash + $bill_description->totalCash);
			}//end while
			$return_result['miniStatement'] = $miniStatement;

			$return_result['subTotalfineItemsTotalSubTotal'] = round($subTotalfineItemsTotalSubTotal, 2);
			$return_result['subTotaljamaItemsSubTotal'] = round($subTotaljamaItemsSubTotal, 2);
			$return_result['subTotalnetMetalBalance'] = round($subTotalnetMetalBalance, 2);
			$return_result['subTotaltotalCash'] = round($subTotaltotalCash, 2);
		}//end if
		
		$mysqli->close();
		$return_result['i'] = $i;
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function getCustomer

	//////////////////////////////////// END CUSTOMER PART //////////////////////////////////////////

	/////////////////////////////////// START BILL PART ////////////////////////////////////////////
	//Delete Bill function
	if($fn == 'getCustomerList'){
		$return_result = array();
		$status = true;	
		$customers = array();
		
		$sql = "SELECT * FROM customer_master ORDER BY customer_name";	
		$result = $mysqli->query($sql);
		while($row = $result->fetch_array()){
			$customer_obj = new stdClass();

			$customer_obj->customer_id = $row['customer_id'];
			$customer_obj->customer_name = $row['customer_name'];
			$customer_obj->phone_number = $row['phone_number'];
			$customer_obj->metal_jama = $row['metal_jama'];
			$customer_obj->metal_due = $row['metal_due'];
			$customer_obj->cash_jama = $row['cash_jama'];
			$customer_obj->cash_due = $row['cash_due'];

			array_push($customers, $customer_obj);
		}//end while
		$return_result['customers'] = $customers;
		$return_result['status'] = $status;

		echo json_encode($return_result);
	}//end function getCustomerList

	//Save Bill function
	if($fn == 'saveBill'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$bill_description = $_POST["bill_description"];
		$bill_id = $_POST["bill_id"];
		$metal_jama = $_POST["metal_jama"];
		$metal_due = $_POST["metal_due"];
		$final_bill = $_POST["final_bill"];
		$bill_edit = $_POST["bill_edit"];
		$paymentType = $_POST["paymentType"];
		$oldDue = $_POST["oldDue"];
		$oldJama = $_POST["oldJama"];

		$status = true;	

		if ($bill_id > 0) {
			//update
			$sql_update = "UPDATE bill_details SET bill_description = '".base64_encode($bill_description)."' WHERE bill_id = '" .$bill_id. "' ";
			$mysqli->query($sql_update);
			$current_bill_id = $bill_id;
		} else {
			//Insert
			$sql_insert = "INSERT INTO bill_details (customer_id, bill_description) VALUES('".$customer_id."', '".base64_encode($bill_description)."')";
			$result_insert = $mysqli->query($sql_insert);
			$current_bill_id = $mysqli->insert_id;
		}

		//For the New Bill creation
		if($bill_edit == 0 && $final_bill == 1){
			$user_sql_update = "UPDATE customer_master SET metal_jama = '".$metal_jama."', metal_due = '".$metal_due."' WHERE customer_id = '" .$customer_id. "' ";
			$mysqli->query($user_sql_update);
		}

		//For the bill Edit Function
		if($bill_edit == 1 && $final_bill == 1 && $customer_id > 0){
			if($paymentType == 'cash'){
				$metal_jama = 0.000;
				$metal_due = 0.000;
			}else{
				$sql_customer = "SELECT * FROM customer_master WHERE customer_id = '".$customer_id."' ";	
				$result_customer = $mysqli->query($sql_customer);
				$row_customer = $result_customer->fetch_array();
				$metal_jama_old = $row_customer['metal_jama'];
				$metal_due_old = $row_customer['metal_due'];

				$metal_jama_new = ($metal_jama_old - $oldJama) + $metal_jama;
				$metal_due_new = ($metal_due_old - $oldDue) + $metal_due;

				if($metal_jama_new == $metal_due_new){
					$metal_jama = 0.000;
					$metal_due = 0.000;
				}else if($metal_jama_new > $metal_due_new){
					$metal_jama = $metal_jama_new - $metal_due_new;
					$metal_due = 0.000;
				}else if($metal_due_new > $metal_jama_new){
					$metal_due = $metal_due_new - $metal_jama_new;
					$metal_jama = 0.000;
				}
			}//end if else

			$user_sql_update = "UPDATE customer_master SET metal_jama = '".$metal_jama."', metal_due = '".$metal_due."' WHERE customer_id = '" .$customer_id. "' ";
			$mysqli->query($user_sql_update);
		}

		//Stock update function start
		$bill_description1 = json_decode($bill_description);
		$fineItems = $bill_description1->fineItems;
		if(sizeof($fineItems) > 0){
			for($i = 0; $i < sizeof($fineItems); $i++){
				$item_id = $fineItems[$i]->item_id;
				$stock_serial_no = $fineItems[$i]->stock_serial_no;
				$stock_status = 0;

				//update item_stock_master Table
				if($stock_serial_no > 0){
					$sql = "UPDATE item_stock_master SET stock_status = '" .$stock_status. "' WHERE item_id = '".$item_id."' AND stock_serial_no = '" .$stock_serial_no. "' ";
					$result = $mysqli->query($sql);
				}
			}//end for
		}//end if
		//Stock update function end

		$mysqli->close();

		$return_result['current_bill_id'] = $current_bill_id;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveCustomer

	//Revert Item stoct status
	if($fn == 'reverseItemStock'){
		$return_result = array();
		$item_id = $_POST["item_id"];
		$stock_serial_no = $_POST["stock_serial_no"];
		$status = true;	
		$stock_status = 1;

		//update item_stock_master Table
		$sql = "UPDATE item_stock_master SET stock_status = '" .$stock_status. "' WHERE item_id = '".$item_id."' AND stock_serial_no = '" .$stock_serial_no. "' ";
		$result = $mysqli->query($sql);

		sleep(1);
		echo json_encode($return_result);
	}//end function

	//Delete Bill function
	if($fn == 'deleteBill'){
		$return_result = array();
		$bill_id = $_POST["bill_id"];
		$status = true;	

		//get the bill and reverse the stock status	
		$sql = "SELECT * FROM bill_details WHERE bill_id = '".$bill_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$bill_description = json_decode(base64_decode($row['bill_description']));
			
			$fineItems = $bill_description->fineItems;
			if(sizeof($fineItems) > 0){
				for($i = 0; $i < sizeof($fineItems); $i++){
					$item_id = $fineItems[$i]->item_id;
					$stock_serial_no = $fineItems[$i]->stock_serial_no;
					$stock_status = 1;

					//update item_stock_master Table
					if($stock_serial_no > 0){
						$sql = "UPDATE item_stock_master SET stock_status = '" .$stock_status. "' WHERE item_id = '".$item_id."' AND stock_serial_no = '" .$stock_serial_no. "' ";
						$result = $mysqli->query($sql);
					}
				}//end for
			}//end if
		}//end if

	
		sleep(2);
		//after reversing the item stock status delete the bill
		$sql = "DELETE FROM bill_details WHERE bill_id = '".$bill_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function deleteBill
	
	//Get getBillDetails
	if($fn == 'getBillDetails'){
		$return_result = array();
		$bill_id = $_POST["bill_id"];
		$status = true;	
	
		$sql = "SELECT * FROM bill_details WHERE bill_id = '".$bill_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$customer_id = $row['customer_id'];
			$bill_description = json_decode(base64_decode($row['bill_description']));
		}
		
		$mysqli->close();
		$return_result['status'] = $status;
		$return_result['customer_id'] = $customer_id;
		$return_result['bill_description'] = $bill_description;
		sleep(1);
		echo json_encode($return_result);
	}//end function getBillDetails

	/////////////////////////////////// END BILL PART ////////////////////////////////////////////


	////////////////////// Item Stock Add Start //////////////////////////////////////////	
	//Save Item stock function
	if($fn == 'addItemStock'){
		$return_result = array();
		$stock_item_id = $_POST["stock_item_id"];
		$stock_serial_no = $_POST["stock_serial_no"];
		$stock_weight = $_POST["stock_weight"];		
		$raw_material_price = $_POST["raw_material_price"];	

		$status = true;	
		$stock_id = 0;

		//Insert
		$sql_check = "SELECT * FROM item_stock_master WHERE stock_serial_no = '" .$stock_serial_no. "' ";
		$result_check = $mysqli->query($sql_check);
		//$mysqli->close();

		if($result_check->num_rows > 0){
			$status = false;	
		}else{
			$sql_insert = "INSERT INTO item_stock_master (item_id, stock_serial_no, stock_weight, raw_material_price) VALUES('".$stock_item_id."', '".$stock_serial_no."', '".$stock_weight."', '" .$raw_material_price. "' )";
			$result_insert = $mysqli->query($sql_insert);
			$stock_id = $mysqli->insert_id;

			if($stock_id > 0){
				$sql_last_serial = "SELECT MAX(stock_serial_no) AS last_serial_no FROM item_stock_master WHERE item_id = '".$stock_item_id."' ";
				$res_last_serial = $mysqli->query($sql_last_serial);
				if(mysqli_num_rows($res_last_serial) > 0){
					$row_last_serial = $res_last_serial->fetch_array();
					$last_serial_no1 = $row_last_serial['last_serial_no'];
					if($last_serial_no1 > 0){
						$last_serial_no = $last_serial_no1 + 1;
					}
				}
			}//end if
			$mysqli->close();
		}//end if

		$return_result['stock_id'] = $stock_id;
		$return_result['last_serial_no'] = $last_serial_no;
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function addItemStock

	//Delete Item stock
	if($fn == 'deleteItemStock'){
		$return_result = array();
		$stock_id = $_POST["stock_id"];
		$status = true;	
	
		$sql = "DELETE FROM item_stock_master WHERE stock_id = '".$stock_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function 

	//Update Item stock
	if($fn == 'updateItemStock'){
		$return_result = array();
		$stock_id = $_POST["stock_id"];
		$stock_serial_no = $_POST["stock_serial_no"];
		$stock_weight = $_POST["stock_weight"];
		$raw_material_price = $_POST["raw_material_price"];
		$status = true;	
	
		$sql = "UPDATE item_stock_master SET stock_serial_no = '" .$stock_serial_no. "', stock_weight = '" .$stock_weight. "', raw_material_price = '" .$raw_material_price. "' WHERE stock_id = '".$stock_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		sleep(1);
		echo json_encode($return_result);
	}//end function 

	//Update Item stock
	if($fn == 'checkSerialNo'){
		$return_result = array();
		$bill_item_id = $_POST["bill_item_id"];
		$bill_stock_serial_no = $_POST["bill_stock_serial_no"];
		$status = true;	
		$stock_weight = 0;
		$raw_material_price = 0.00;
		$stock_status = 1;

		$sql_check = "SELECT * FROM item_stock_master WHERE item_id = '" .$bill_item_id. "' AND stock_serial_no = '" .$bill_stock_serial_no. "' AND stock_status = '" .$stock_status. "' ";
		$result_check = $mysqli->query($sql_check);
		if($result_check->num_rows > 0){
			$status = true;	
			$row = $result_check->fetch_array();
			$stock_weight = $row['stock_weight'];
			$raw_material_price = $row['raw_material_price'];
		}else{
			$status = false;	
		}
		$return_result['status'] = $status;
		$return_result['stock_weight'] = $stock_weight;
		$return_result['raw_material_price'] = $raw_material_price;

		sleep(1);
		echo json_encode($return_result);
	}//end function 



	///////////////////// Item Stock Add End ///////////////////////////////////////////
	
	?>