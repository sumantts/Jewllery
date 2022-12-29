//Login Page Function
	$("#username").change(function(){ 
		$('#username_error').html('');
	});
	$("#password").change(function(){ 
		$('#password_error').html('');
	});
	
	$( "#login_btn" ).on( "click", function() {
		$username = $('#username').val();
		$password = $('#password').val();
		$cpatchaTextBox = $('#cpatchaTextBox').val();
		
		var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
		
		if($username == ''){
			$('#username_error').html('Please Enter Username');
		}else if($password == ''){
			$('#password_error').html('Please Enter password');
		}else{			
			$.ajax({
			  method: "POST",
			  url: "assets/php/function.php",
			  data: { fn: "doLogin", username: $username, password: $password }
			})
			  .done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					window.location.href = '?p=dashboard';
				}else{
					$('#error_text').html('Wrong username or password');
				}
			});
			return false;
		}//end if else
	});

	//////////////////// ITEM FUNCTION START //////////////////////////
	//Show Modal
	function openItemModal(){
		console.log('Open the Item Modal');
		modal.style.display = "block";
	}
	//Close Modal
	function closeItemModal(){
		console.log('Close the Item Modal');
		$('#item_id').val('0');
		$('#item_name').val('');
		$('#first_tunch').val('');
		$('#second_tunch').val('00.00');
		$('#total_tunch').val('');
		modal.style.display = "none";
	}
	$("#item_name").change(function(){ 
		$('#item_name_error').html('');
	});
	//Calculation
	$("#first_tunch, #second_tunch").blur(function(){ 
		$first_tunch = $('#first_tunch').val();
		$second_tunch = $('#second_tunch').val();
		$total_tunch = 0;
		$total_tunch = parseFloat($first_tunch) + parseFloat($second_tunch);
		$('#total_tunch').val($total_tunch.toFixed(2));
		$('#first_tunch_error').html('');
	});

	//Save Function
	$("#saveItem").click(function(){
		$item_id = $('#item_id').val();
		$item_name = $('#item_name').val();
		$first_tunch = $('#first_tunch').val();
		$second_tunch = $('#second_tunch').val();
		$total_tunch = $('#total_tunch').val();

		if($item_name == ''){
			$('#item_name_error').html('Please Enter Item Name');
		}else if($first_tunch == ''){
			$('#first_tunch_error').html('Please Enter First Tunch');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveItem", item_id: $item_id, item_name: $item_name, first_tunch: $first_tunch, second_tunch: $second_tunch, total_tunch: $total_tunch }
			})
			.done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){					
					$('#item_name_error').html('');
					$('#first_tunch_error').html('');
					$('#item_name').val('');
					$('#first_tunch').val('');
					$('#second_tunch').val('00.00');
					$('#total_tunch').val('');
					
					if($item_id == '0'){	
						//start
						const table = $("#dataTable").DataTable();
						// or using tr
						const tr = $("<tr id=item_id_"+$res1.item_id+"><td>"+$item_name+"</td><td style='text-align: right;'>"+$first_tunch+"</td><td style='text-align: right;'>"+$second_tunch+"</td><td style='text-align: right;'>"+$total_tunch+"</td><td><a class='btn btn-primary' onclick=updateItemModal("+$res1.item_id+")>Update</a><a class='btn btn-danger' onclick=deleteItem("+$res1.item_id+")>Delete</a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#item_id_'+$item_id).html('');

						$('#item_id_'+$item_id).html("<td>"+$item_name+"</td><td style='text-align: right;'>"+$first_tunch+"</td><td style='text-align: right;'>"+$second_tunch+"</td><td style='text-align: right;'>"+$total_tunch+"</td><td><a class='btn btn-primary' onclick=updateItemModal("+$item_id+")>Update</a><a class='btn btn-danger' onclick=deleteItem("+$item_id+")>Delete</a></td>");
					}	
					modal.style.display = "none";
				}else{
					$('#item_name_error').html('Item Name already exists');
				}
			});//end ajax
		}//end if
	});//end saveItem function

	//Update function	
	function updateItemModal($item_id){		
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getItem", item_id: $item_id }
		})
		.done(function( res ) {
			console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#item_id').val($res1.item_id);
				$('#item_name').val($res1.item_name);
				$('#first_tunch').val($res1.first_tunch);
				$('#second_tunch').val($res1.second_tunch);
				$('#total_tunch').val($res1.total_tunch);
				modal.style.display = "block";
			}else{
				$('#item_name_error').html('Item Name already exists');
			}
		});//end ajax
	}

	//Delete function	
	function deleteItem($item_id){
		console.log('Delete Item: '+$item_id);
		if (confirm('Are you sure to delete the Item?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteItem", item_id: $item_id }
			})
			.done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#item_id_'+$item_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	//////////////////// ITEM FUNCTION END //////////////////////////

	//////////////////// CUSTOMER FUNCTION START //////////////////////////
	//Show Modal
	function openCustomerModal(){
		console.log('Open the Item Modal');
		modalCustomer.style.display = "block";
	}

	//Close Modal
	function closeCustomerModal(){
		console.log('Close the Item Modal');
		modalCustomer.style.display = "none";
	}

	$("#customer_name, #phone_number").blur(function(){ 
		$('#customer_name_error').html('');
		$('#phone_number_error').html('');
	});

	//Save Function
	$("#saveCustomer").click(function(){		
		$customer_id = $('#customer_id').val();
		$customer_name = $('#customer_name').val();
		$phone_number = $('#phone_number').val();

		if($customer_name == ''){
			$('#customer_name_error').html('Please Enter Customer Name');
		}else if($phone_number == ''){
			$('#phone_number_error').html('Please Enter Phone Number');
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "saveCustomer", customer_id: $customer_id, customer_name: $customer_name, phone_number: $phone_number }
			})
			.done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){					
					$('#customer_name_error').html('');
					$('#phone_number_error').html('');
					$('#customer_name').val('');
					$('#phone_number').val('');
					
					if($customer_id == '0'){	
						const table = $("#dataTable").DataTable();
						const tr = $("<tr id=customer_id_"+$res1.customer_id+"><td>"+$customer_name+"</td><td>"+$phone_number+"</td><td style='text-align: right;'>0.00</td><td style='text-align: right;'>0.00</td><td style='text-align: right;'>0.00</td><td style='text-align: right;'>0.00</td><td><a class='btn btn-primary' onclick=updateCustomerModal("+$res1.customer_id+")>Update</a><a class='btn btn-danger' onclick=deleteCustomer("+$res1.customer_id+")>Delete</a><a class='btn btn-primary' onclick=miniStatement("+$res1.customer_id+")>Mini. Slip</a></td></tr>");
						table.row.add(tr[0]).draw();
					} else{
						console.log('Updatre the table row');
						$('#customer_id_'+$customer_id).html('');

						$('#customer_id_'+$customer_id).html("<td>"+$customer_name+"</td><td>"+$phone_number+"</td><td style='text-align: right;'>"+$res1.metal_jama+"</td><td style='text-align: right;'>"+$res1.metal_due+"</td><td style='text-align: right;'>"+$res1.cash_jama+"</td><td style='text-align: right;'>"+$res1.cash_due+"</td><td><a class='btn btn-primary' onclick=updateCustomerModal("+$customer_id+")>Update</a><a class='btn btn-danger' onclick=deleteCustomer("+$customer_id+")>Delete</a><a class='btn btn-primary' onclick=miniStatement("+$res1.customer_id+")>Mini. Slip</a></td>");
					}	
					modalCustomer.style.display = "none";
				}else{
					$('#customer_name_error').html('Customer Name already exists');
				}
			});//end ajax
		}//end if
	});

	//Update function	
	function updateCustomerModal($customer_id){	
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "getCustomer", customer_id: $customer_id }
		})
		.done(function( res ) {
			console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#customer_id').val($res1.customer_id);
				$('#customer_name').val($res1.customer_name);
				$('#phone_number').val($res1.phone_number);
				modalCustomer.style.display = "block";
			}
		});//end ajax
	}

	//Delete function	
	function deleteCustomer($customer_id){
		console.log('Delete Customer: '+$customer_id);
		if (confirm('Are you sure to delete the Customer?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteCustomer", customer_id: $customer_id }
			})
			.done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#customer_id_'+$customer_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	function miniStatement($customer_id){
		//Fetch data
		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "miniStatement", customer_id: $customer_id }
		})
		.done(function( res ) {
			console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#tbody_ministatement').html('');
				if(parseInt($res1.i) > 0){
					var generatedRow = '';
					for(var j = 0; j < $res1.miniStatement.length; j++){
						generatedRow += "<tr><td>"+$res1.miniStatement[j].i+"</td><td>"+$res1.miniStatement[j].billId+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].fineItemsTotalSubTotal+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].jamaItemsSubTotal+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].netMetalBalance+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].netMetalBalance+"</td><td style='text-align: right;'>"+$res1.miniStatement[j].totalCash+"</td><td>"+$res1.miniStatement[j].create_date+"</td></tr>";
					}//end for

					if(parseInt($res1.i) > 1){
						generatedRow += "<tr style='font-weight: bold;'><td>&nbsp;</td><td>Total</td><td style='text-align: right;'>"+$res1.subTotalfineItemsTotalSubTotal+"</td><td style='text-align: right;'>"+$res1.subTotaljamaItemsSubTotal+"</td><td style='text-align: right;'>"+$res1.subTotalnetMetalBalance+"</td><td style='text-align: right;'>"+$res1.subTotalnetMetalBalance+"</td><td style='text-align: right;'>"+$res1.subTotaltotalCash+"</td><td>&nbsp;</td></tr>";
					}//end if

					$('#tbody_ministatement').html(generatedRow);
				}else{
					var generatedRow = "<tr><td colspan='7'>No Record Available</td></tr>";
					$('#tbody_ministatement').html(generatedRow);
				}
				
				miniSlip.style.display = "block";
			}
		});//end ajax

	}//end 
	//Close Modal
	function closeMiniSlipModal(){
		console.log('Close the minislip Modal');
		miniSlip.style.display = "none";
	}
	//////////////////// CUSTOMER FUNCTION END //////////////////////////

	//////////////////// BILL FUNCTION START //////////////////////////
	//Show Modal
	function openBillModal($current_bill_id){
		console.log('Open the Item Modal');
		$('#current_bill_id').val($current_bill_id);

		if($current_bill_id == '0'){
			$final_bill = 0;
			$bill_edit = 0;

			//Populate Customer List
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "getCustomerList", }
			})
			.done(function( res ) {
				//console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$customers = $res1.customers;
					$('#bill_customer_id').html('');
					$options = "<option selected value='0'>Select Customer</option>";
					for(var i = 0; i < $customers.length; i++){
						$options += "<option value="+$customers[i].customer_id+" customer_name="+$customers[i].customer_name+" phone_number="+$customers[i].phone_number+" metal_jama="+$customers[i].metal_jama+" metal_due="+$customers[i].metal_due+" cash_jama="+$customers[i].cash_jama+" cash_due="+$customers[i].cash_due+">"+$customers[i].customer_name+" ("+$customers[i].phone_number+")</option>";
					}
					$('#bill_customer_id').html($options);					
					$('#bill_customer_id').prop('disabled', false);
				}
			});//end ajax

			const d = new Date();		
			$billId = d.getDate() +''+ ( d.getMonth() + 1 )+''+ d.getFullYear()+''+ d.getHours()+''+ d.getMinutes()+''+ d.getSeconds();

			$billDetail = {
				billId: $billId,
				customer_id: '0',
				customer_name: 'Guest Customer',
				phone_number: '',
				guestUserPhone: '',
				metal_jama: '0.000',
				metal_due: '0.000',
				cash_jama: '0.00',
				cash_due: '0.00',
				old_balance_cash: '',
				fineItems: [],
				fineItemsSubTotal: '00.000',
				fineItemsTotalSubTotal: '00.000',
				jamaItems: [],
				jamaItemsSubTotal: '00.000',
				netMetalBalance: '00.000',
				netMetalBalanceType: '',
				paymentType: '',
				ratePerGm: '0.00',
				totalCash: '0.00',
				metal_label: '',	
				old_balance_metal: '00.000',
				amountJama: '0.00',	
				partPayment: []
			}

			$('#old_balance_metal').val('');
			$('#old_balance_cash').val('');
			//$('#billedItem').html('');
			$("#tbody_billedItem").empty();
			$('#fineItemsSubTotal').html('0.000');
			$('#fineItemsTotalSubTotal').html('0.000');
			//$('#jamaDetails').html('');
			$("#tbody_jamaDetails").empty();
			$('#jamaItemsSubTotal').html('0.000');
			$('#netMetalBalance').html('0.000');
			$('#totalCash').val('');
			$('#ratePerGm').val('');
			$('#guestUserPhone').val('');
			document.getElementById('cash').checked = false;
			document.getElementById('due').checked = false;
			$('#createFinalBill').prop('disabled', true);

			modalCustomer.style.display = "block";
		}else{
			//Update Bill Section
			$final_bill = 0;
			$bill_edit = 1;
			
			//Fetch data
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "getBillDetails", bill_id: $current_bill_id }
			})
			.done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$billDetail = $res1.bill_description;

					$('#bill_customer_id').val($billDetail.customer_id);
					$('#bill_customer_id').prop('disabled', 'disabled');

					$old_balance_metal = '00.000';
					$old_balance_cash = '-';
					$metal_label = 'Old balance(Metal)';
					$cash_label = 'Old balance(Cash)';

					if(parseFloat($billDetail.metal_jama) > 0.001){
						$old_balance_metal = $billDetail.metal_jama;
						$metal_label = 'Old balance(Metal Jama)';
					}else if(parseFloat($billDetail.metal_due) > 0.001){
						$old_balance_metal = $billDetail.metal_due;
						$metal_label = 'Old balance(Metal Due)';
					}else if(parseFloat($billDetail.cash_jama) > 0.01){
						$old_balance_cash = $billDetail.cash_jama;
						$cash_label = 'Old balance(Cash Jama)';
					}else if(parseFloat($billDetail.cash_due) > 0.01){
						$old_balance_cash = $billDetail.cash_due;
						$cash_label = 'Old balance(Cash Due)';			
					}else{
						$old_balance_metal = '';
						$old_balance_cash = '';
						$metal_label = 'Old balance(Metal)';
						$cash_label = 'Old balance(Cash)';
					}//en d if else

					$('#metal_label').html($metal_label);
					$('#old_balance_metal').val($old_balance_metal);
					$('#cash_label').html($cash_label);
					$('#old_balance_cash').val($old_balance_cash);
					$('#guestUserPhone').val($billDetail.guestUserPhone);

					//Populate Fine Item List
					$loopFineItems = $billDetail.fineItems;
					//Set the data into the table
					$new_row = "";
					$('#tbody_billedItem').html('');

					for(var i = 0; i < $loopFineItems.length; i++){
						$new_row += "<tr id=fine_item_obj_"+$loopFineItems[i].fine_item_obj+"><td>"+$loopFineItems[i].item_name+" ("+$loopFineItems[i].revised_first_tunch+" + "+$loopFineItems[i].revised_second_tunch+")</td><td class='text-right'>"+$loopFineItems[i].item_weight+"</td><td class='text-right'>"+$loopFineItems[i].revised_first_tunch+"</td><td class='text-right'>"+$loopFineItems[i].revised_second_tunch+"</td><td class='text-right'>"+$loopFineItems[i].item_fine+"</td><td><button type='button' class='btn btn-secondary btn-sm' onclick=removeFineItems("+$loopFineItems[i].fine_item_obj+','+$loopFineItems[i].item_fine+")>Delete</button></td></tr>";						
					}//end for	

					$('#tbody_billedItem').html($new_row);
					$('#fineItemsSubTotal').html($billDetail.fineItemsSubTotal);
					$('#fineItemsTotalSubTotal').html($billDetail.fineItemsTotalSubTotal);
					
					//Populate Jama Item list
					$loopJamaItems = $billDetail.jamaItems;
					$new_jama_row = "";
					$('#tbody_jamaDetails').html('');
					
					for(var j = 0; j < $loopJamaItems.length; j++){
						$new_jama_row += "<tr id=jama_item_obj_"+$loopJamaItems[j].jama_item_obj+"> <td colspan='5'>"+$loopJamaItems[j].jama_item+"</td> <td class='text-right'>"+$loopJamaItems[j].jama_item_weight+"</td> <td> <button type='button' class='btn btn-secondary btn-sm' onclick=removeJamaDetails("+$loopJamaItems[j].jama_item_obj+','+$loopJamaItems[j].jama_item_weight+")>Delete</button> </td></tr>";
					}//end for

					$('#tbody_jamaDetails').html($new_jama_row);
					$('#jamaItemsSubTotal').html($billDetail.jamaItemsSubTotal);

					if(parseFloat($billDetail.netMetalBalance) > 0.001){
						$('#netMetalBalance').html($billDetail.netMetalBalance + '/- Due');
						$('#oldDue').val($billDetail.netMetalBalance);
					}else{
						$('#netMetalBalance').html($billDetail.netMetalBalance + '/- Jama');
						$oldJama1 = ($billDetail.netMetalBalance * -1); 
						$('#oldJama').val($oldJama1);
					}

					//Payment Type Part
					if($billDetail.paymentType == 'due'){
						$('#due').attr('checked',true);
						$('#ratePerGm').val('');
						$('#totalCash').val('');
						$('#rateBlock').hide();
						$('#totalCashBlock').hide();
					}
					if($billDetail.paymentType == 'cash'){
						$('#cash').attr('checked',true);
						$('#ratePerGm').val($billDetail.ratePerGm);
						$('#totalCash').val($billDetail.totalCash);
						$('#rateBlock').show();
						$('#totalCashBlock').show();
					}

					$('#amountJama').val($billDetail.amountJama);

					modalCustomer.style.display = "block";
				}
			});//end ajax
		}//end if

		
	}//end fnction

	//Close Bill Modal
	function closeBillModal(){
		console.log('Close the Item Modal');
		modalBill.style.display = "none";
	}

	$("#bill_customer_id").change(function(){ 
		$('#customer_id_error').html('');
		$('#guestUserPhone_error').html('');

		var bill_customer_id = $('#bill_customer_id').find('option:selected'); 
        $metal_jama = bill_customer_id.attr("metal_jama"); 
        $metal_due = bill_customer_id.attr("metal_due");
        $cash_jama = bill_customer_id.attr("cash_jama"); 
        $cash_due = bill_customer_id.attr("cash_due");  
		$customer_id_n = $('#bill_customer_id').val();
		$customer_name = $("#bill_customer_id option:selected").text();
        $phone_number = bill_customer_id.attr("phone_number");
        $guestUserPhone = $('#guestUserPhone').val();

		$billDetail.metal_jama = $metal_jama;
		$billDetail.metal_due = $metal_due;
		$billDetail.cash_jama = $cash_jama;
		$billDetail.cash_due = $cash_due;
		$billDetail.customer_id = $customer_id_n;
		if(parseInt($customer_id_n) == 0){
			$billDetail.customer_name = 'Guest Customer';
			$billDetail.phone_number = $guestUserPhone;
		}else{
			$billDetail.customer_name = $customer_name;
			$billDetail.phone_number = $phone_number;
		}
		$old_balance_metal = '00.000';
		$old_balance_cash = '-';
		$metal_label = 'Old balance(Metal)';
		$cash_label = 'Old balance(Cash)';

		if(parseFloat($metal_jama) > 0.001){
			$old_balance_metal = $metal_jama;
			$metal_label = 'Old balance(Metal Jama)';
		}else if(parseFloat($metal_due) > 0.001){
			$old_balance_metal = $metal_due;
			$metal_label = 'Old balance(Metal Due)';
		}else if(parseFloat($cash_jama) > 0.01){
			$old_balance_cash = $cash_jama;
			$cash_label = 'Old balance(Cash Jama)';
		}else if(parseFloat($cash_due) > 0.01){
			$old_balance_cash = $cash_due;
			$cash_label = 'Old balance(Cash Due)';			
		}else{
			$old_balance_metal = '';
			$old_balance_cash = '';
			$metal_label = 'Old balance(Metal)';
			$cash_label = 'Old balance(Cash)';
		}//en d if else

		$('#metal_label').html($metal_label);
		$('#old_balance_metal').val($old_balance_metal);
		$('#cash_label').html($cash_label);
		$('#old_balance_cash').val($old_balance_cash);
		
		$billDetail.old_balance_metal = $old_balance_metal;
		$billDetail.metal_label = $metal_label;

	});

	$("#bill_item_id").change(function(){ 
		$('#item_id_error').html('');
		var bill_item_id = $('#bill_item_id').find('option:selected'); 
        $first_tunch = bill_item_id.attr("first_tunch"); 
        $second_tunch = bill_item_id.attr("second_tunch");
		$('#first_tunch').val($first_tunch);
		$('#second_tunch').val($second_tunch);
		updateFine();
	});

	$("#item_weight, #first_tunch, #second_tunch").blur(function(){ 
		$('#item_weight_error').html('');
		updateFine();
	});

	$("#bill_stock_serial_no").blur(function(){ 
		$bill_stock_serial_no = $('#bill_stock_serial_no').val();
		$bill_item_id = $('#bill_item_id').val();
		console.log('bill_stock_serial_no:' + $bill_stock_serial_no);
		
		if(parseInt($bill_stock_serial_no) > 0 && parseInt($bill_item_id) > 0){
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "checkSerialNo", bill_item_id: $bill_item_id, bill_stock_serial_no: $bill_stock_serial_no }
			})
			.done(function( res ) {			
				$res1 = JSON.parse(res);
				console.log(JSON.stringify($res1))
				if($res1.status == true){
					$('#item_weight').val($res1.stock_weight);
					$('#raw_material_price').val($res1.raw_material_price);
				}else{
					$('#item_weight').val($res1.stock_weight);	
					$('#raw_material_price').val($res1.raw_material_price);				
				}
			});//end ajax
		}else{
			$('#item_weight').val('');	
			$('#raw_material_price').val('0.00');				
		}//end
		
	});

	function updateFine(){
        $first_tonch = $('#first_tunch').val(); 
        $second_tonch = $('#second_tunch').val(); 
		$item_weight = $('#item_weight').val();

		if($item_weight > 0){
			$total_tonch = parseFloat($first_tonch) + parseFloat($second_tonch);
			$fine_waight = ($item_weight * $total_tonch) / 100;
			console.log('Before rounding fine_waight: ' + $fine_waight);
			$fine_waight1 = toFixedTrunc($fine_waight, 3);
			$('#item_fine').val($fine_waight1);
			console.log('after rounding fine_waight: ' + $fine_waight1);
		}		
	}//end function

	//Add Fine Item	
	$("#addBillItem").click(function(){
		var bill_item_id_str = $('#bill_item_id').find('option:selected'); 
		$bill_item_id = $('#bill_item_id').val();
		$item_name = bill_item_id_str.attr("item_name"); 
        $first_tunch = bill_item_id_str.attr("first_tunch"); 
        $second_tunch = bill_item_id_str.attr("second_tunch");
		$revised_first_tunch = $('#first_tunch').val();
		$revised_second_tunch = $('#second_tunch').val();
		$item_weight = $('#item_weight').val();
		$raw_material_price = $('#raw_material_price').val();
		$item_fine = $('#item_fine').val();
		$bill_stock_serial_no = $('#bill_stock_serial_no').val();

		if(parseInt($bill_item_id) == 0){
			$('#item_id_error').html('Please Select Item Name');
		}else if($item_weight == '' || parseFloat($item_weight) < 0.001){
			$('#item_weight_error').html('Item Weight Required');
		}else{
			$('#item_id_error').html('');
			$('#item_weight_error').html('');

			$fine_item_obj = Math.floor(Math.random() * 100);
			$fineItem = {
				fine_item_obj: $fine_item_obj,
				item_id: $bill_item_id,
				item_name: $item_name,
				item_weight: $item_weight,
				item_fine: $item_fine,
				first_tunch: $first_tunch,
				second_tunch: $second_tunch,
				revised_first_tunch: $revised_first_tunch,
				revised_second_tunch: $revised_second_tunch,
				stock_serial_no: $bill_stock_serial_no,
				raw_material_price: $raw_material_price
			};
			$billDetail.fineItems.push($fineItem);

			$fineItemsSubTotal1 = parseFloat($billDetail.fineItemsSubTotal) + parseFloat($item_fine);
			$billDetail.fineItemsSubTotal = toFixedTrunc($fineItemsSubTotal1, 3);

			$tempfineItemsTotalSubTotal = parseFloat($billDetail.fineItemsSubTotal) / 99.50;
			$tempfineItemsTotalSubTotal1 = parseFloat($tempfineItemsTotalSubTotal) * 100;			
			$billDetail.fineItemsTotalSubTotal = toFixedTrunc($tempfineItemsTotalSubTotal1, 3);
			

			//Clear the Input fields
			$('#bill_item_id').val('0');
			$('#first_tunch').val('');
			$('#second_tunch').val('');
			$('#item_weight').val('');
			$('#raw_material_price').val('0.00');
			$('#item_fine').val('');
			$('#bill_stock_serial_no').val('');

			//Set the data into the table
			$new_row = "<tr id=fine_item_obj_"+$fine_item_obj+"><td>"+$item_name+" ("+$revised_first_tunch+" + "+$revised_second_tunch+")</td><td class='text-right'>"+$item_weight+"</td><td class='text-right'>"+$revised_first_tunch+"</td><td class='text-right'>"+$revised_second_tunch+"</td><td class='text-right'>"+$item_fine+"</td><td><button type='button' class='btn btn-secondary btn-sm' onclick=removeFineItems("+$fine_item_obj+','+$item_fine+")>Delete</button></td></tr>";

			$('#billedItem').append($new_row);
			$('#fineItemsSubTotal').html($billDetail.fineItemsSubTotal);
			$('#fineItemsTotalSubTotal').html($billDetail.fineItemsTotalSubTotal);
			calculateNetMetalQuantity();
		}//end if 
	});

	//Remove Fine Items from the table
	function removeFineItems($fine_item_obj, $item_fine){
		$fineItemsTemp = [];
		for(var i = 0; i < $billDetail.fineItems.length; i++){
			if($billDetail.fineItems[i].fine_item_obj != $fine_item_obj){
				$fineItemsTemp.push($billDetail.fineItems[i]);
			}

			if($billDetail.fineItems[i].fine_item_obj == $fine_item_obj){
				$stock_serial_no = $billDetail.fineItems[i].stock_serial_no;
				$item_id = $billDetail.fineItems[i].item_id;
				if(parseInt($stock_serial_no) > 0 && parseInt($item_id) > 0){
					$.ajax({
						method: "POST",
						url: "assets/php/function.php",
						data: { fn: "reverseItemStock", item_id: $item_id, stock_serial_no: $stock_serial_no }
					})
					.done(function( res ) {
						console.log(res);
						$res1 = JSON.parse(res);
						if($res1.status == true){						
							//do nothing
						}
					});//end ajax
				}
			}//end if

		}//end for
		$billDetail.fineItems = [];
		$billDetail.fineItems = $fineItemsTemp;

		$fineItemsSubTotal1 = parseFloat($billDetail.fineItemsSubTotal) - parseFloat($item_fine);	
		$billDetail.fineItemsSubTotal = toFixedTrunc($fineItemsSubTotal1, 3);	
		$('#fineItemsSubTotal').html($billDetail.fineItemsSubTotal);

		$tempfineItemsTotalSubTotal = parseFloat($billDetail.fineItemsSubTotal) / 99.50;
		$tempfineItemsTotalSubTotal1 = parseFloat($tempfineItemsTotalSubTotal) * 100;
		$billDetail.fineItemsTotalSubTotal = toFixedTrunc($tempfineItemsTotalSubTotal1, 3);

		if($billDetail.fineItemsTotalSubTotal > 0){
			$('#fineItemsTotalSubTotal').html($billDetail.fineItemsTotalSubTotal);
		}else{
			$('#fineItemsTotalSubTotal').html('0.000');
		}

		$('#fine_item_obj_'+$fine_item_obj).remove();
		calculateNetMetalQuantity();
	}

	//Add Jama Details
	$("#adJamaDetail").click(function(){
		$jama_item_obj = Math.floor(Math.random() * 100);
		$jama_item = $('#jama_item').val();
		$jama_item_weight = $('#jama_item_weight').val();

		if(parseFloat($jama_item_weight) > 0){
			$('#jama_item_weight_error').html('');
			$jamaItem = {
				jama_item_obj: $jama_item_obj,
				jama_item: $jama_item,
				jama_item_weight: $jama_item_weight
			}
			$billDetail.jamaItems.push($jamaItem);
			//$('#jama_item').val('');
			$('#jama_item_weight').val('');

			$new_jama_row = "<tr id=jama_item_obj_"+$jama_item_obj+"> <td colspan='5'>"+$jama_item+"</td> <td class='text-right'>"+$jama_item_weight+"</td> <td> <button type='button' class='btn btn-secondary btn-sm' onclick=removeJamaDetails("+$jama_item_obj+','+$jama_item_weight+")>Delete</button> </td></tr>";
			$('#jamaDetails').append($new_jama_row);

			$jamaItemsSubTotal1 = parseFloat($billDetail.jamaItemsSubTotal) + parseFloat($jama_item_weight);
			$billDetail.jamaItemsSubTotal = toFixedTrunc($jamaItemsSubTotal1, 3);

			console.log('jama item weight'+$jama_item_weight)
			$('#jamaItemsSubTotal').html($billDetail.jamaItemsSubTotal);
			calculateNetMetalQuantity();
		}else{
			$('#jama_item_weight_error').html('Please enter Weight');
		}
	});

	//Remove Jama Details from the table
	function removeJamaDetails($jama_item_obj, $jama_item_weight){
		$jamaItemsTemp = [];
		for(var i = 0; i < $billDetail.jamaItems.length; i++){
			if($billDetail.jamaItems[i].jama_item_obj != $jama_item_obj){
				$jamaItemsTemp.push($billDetail.jamaItems[i]);
			}
		}//end for
		$billDetail.jamaItems = [];
		$billDetail.jamaItems = $jamaItemsTemp;

		$jamaItemsSubTotal1 = parseFloat($billDetail.jamaItemsSubTotal) - parseFloat($jama_item_weight);
		$billDetail.jamaItemsSubTotal = toFixedTrunc($jamaItemsSubTotal1, 3);		
		$('#jamaItemsSubTotal').html($billDetail.jamaItemsSubTotal);
		
		$('#jamaItemsSubTotal').html($billDetail.jamaItemsSubTotal);

		$('#jama_item_obj_'+$jama_item_obj).remove();
		calculateNetMetalQuantity();
	}

	//Calculate Net Metal Quantity
	function calculateNetMetalQuantity(){
		var bill_customer_id = $('#bill_customer_id').find('option:selected'); 
		$customer_id_n = $('#bill_customer_id').val();
		$customer_name = $("#bill_customer_id option:selected").text();
		$phone_number = bill_customer_id.attr("phone_number");
		$guestUserPhone = $('#guestUserPhone').val();
				
		if(parseInt($customer_id_n) == 0){
			$billDetail.customer_name = 'Guest Customer';
			$billDetail.phone_number = $guestUserPhone;
			$billDetail.guestUserPhone = $guestUserPhone;
		}else{
			$billDetail.customer_name = $customer_name;
			$billDetail.phone_number = $phone_number;
			$billDetail.guestUserPhone = '';
		}

		$finePlusOldBalance = 0.000;
		$finalMetalStatus = '';
		$metal_jama = 0.000;
		$metal_due = 0.000;
		$bill_id = $('#current_bill_id').val();
		$oldDue = 0;
		$oldJama = 0;

		if(parseFloat($billDetail.metal_jama) > 0.001){
			$finePlusOldBalance = parseFloat($billDetail.fineItemsTotalSubTotal) - parseFloat($billDetail.metal_jama);
		}else if(parseFloat($billDetail.metal_due) > 0.001){
			$finePlusOldBalance = parseFloat($billDetail.fineItemsTotalSubTotal) + parseFloat($billDetail.metal_due);
		}else{
			$finePlusOldBalance = parseFloat($billDetail.fineItemsTotalSubTotal);
		}
		console.log('finePlusOldBalance:'+$finePlusOldBalance+' jamaItemsSubTotal:'+$billDetail.jamaItemsSubTotal);

		$netMetalBalance1 = parseFloat($finePlusOldBalance) - parseFloat($billDetail.jamaItemsSubTotal);
		$billDetail.netMetalBalance = toFixedTrunc($netMetalBalance1, 3);

		if(parseFloat($billDetail.netMetalBalance) > 0.001){
			$('#netMetalBalance').html($billDetail.netMetalBalance + '/- Due');
			$billDetail.netMetalBalanceType = 'Due';
			$metal_due = $billDetail.netMetalBalance;
		}else{
			$('#netMetalBalance').html($billDetail.netMetalBalance + '/- Jama');
			$billDetail.netMetalBalanceType = 'Jama';
			$metal_jama1 = $billDetail.netMetalBalance;
			$metal_jama = $metal_jama1 * -1;
		}

		if($billDetail.paymentType == 'cash' || parseFloat($billDetail.totalCash) > 0){
			$metal_due = 0.000;
			$metal_jama = 0.000;
		}
		//console.log(JSON.stringify($billDetail));
		if($final_bill == 1){
			$oldDue = $('#oldDue').val();
			$oldJama = $('#oldJama').val();
		}

		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "saveBill", customer_id: $billDetail.customer_id, bill_description: JSON.stringify($billDetail), bill_id: $bill_id, metal_due: $metal_due, metal_jama: $metal_jama, final_bill: $final_bill, bill_edit: $bill_edit, paymentType: $billDetail.paymentType, oldDue: $oldDue, oldJama: $oldJama }
		})
		.done(function( res ) {
			$res1 = JSON.parse(res);
			if($res1.status == true){	
				$current_bill_id = $res1.current_bill_id;
				$('#current_bill_id').val($current_bill_id);
				
				if($bill_id == '0'){
					const tr = $("<tr id=bill_row_"+$current_bill_id+" style='font-weight: bold;'><td>#0</td><td>"+$billDetail.customer_name+"</td><td>"+$billDetail.phone_number+"</td><td style='text-align: right;'>"+$billDetail.fineItemsTotalSubTotal+"</td><td style='text-align: right;'>"+$billDetail.jamaItemsSubTotal+"</td><td> <a class='btn btn-primary' onclick=openBillModal("+$current_bill_id+")>Update</a> <a class='btn btn-danger' onclick=deleteBill("+$current_bill_id+")>Delete</a> <a href=pages/bill_printer/bill_pdf.php?bill_id="+$current_bill_id+" target=_blank class='btn btn-primary' >Print</a></td></tr>");
					
					$('#todaysBill').prepend($(tr));

				} else{
					console.log('Updatre the table row');
					$('#bill_row_'+$current_bill_id).html('');

					$('#bill_row_'+$current_bill_id).html("<td style='font-weight: bold;'>#0</td><td style='font-weight: bold;'>"+$billDetail.customer_name+"</td><td style='font-weight: bold;'>"+$billDetail.phone_number+"</td><td style='text-align: right;font-weight: bold;'>"+$billDetail.fineItemsTotalSubTotal+"</td><td style='text-align: right;font-weight: bold;'>"+$billDetail.jamaItemsSubTotal+"</td><td> <a class='btn btn-primary' onclick=openBillModal("+$current_bill_id+")>Update</a> <a class='btn btn-danger' onclick=deleteBill("+$current_bill_id+")>Delete</a> <a href=pages/bill_printer/bill_pdf.php?bill_id="+$current_bill_id+" target=_blank class='btn btn-primary' >Print</a></td>");
				}

				//Redirect to the printer page
				if($final_bill == 1){
					var URL = 'http://localhost/jewellery_v2/pages/bill_printer/bill_pdf.php?bill_id='+$current_bill_id;
					window.open(URL, '_blank');
				}
				
			}
		});//end ajax
		
	}//end function

	$("#jama_item_weight").blur(function(){ 
		updateJamaFine();
	});

	$("#jama_item_percentage").blur(function(){ 
		updateJamaFine();
	});

	function updateJamaFine(){ 
		$jama_item_weight = $('#jama_item_weight').val();
		$jama_item_percentage = $('#jama_item_percentage').val();

		if($jama_item_weight != undefined && $jama_item_percentage != undefined){
			$jama_fine_waight = ($jama_item_weight * $jama_item_percentage) / 100;
			$jama_fine_waight1 = toFixedTrunc($jama_fine_waight, 3);

			$('#jama_item_fine').val($jama_fine_waight1);
		}		
	}//end function


	//Payment Type Event
	$('#cash').change(function() {
        if($(this).is(":checked")) {
			$('#rateBlock').show();
			$('#totalCashBlock').show();
			$billDetail.paymentType = 'cash';
			$('#createFinalBill').prop('disabled', false);			
        }    
    });

	$('#due').change(function() {
        if($(this).is(":checked")) {
			$('#rateBlock').hide();
			$('#totalCashBlock').hide();
			$billDetail.paymentType = 'due';
			$('#createFinalBill').prop('disabled', false);
			$billDetail.ratePerGm = '0.00';
			$billDetail.totalCash = '0.00';
        }     
    });

	//Rate per Gm Calculation
	$("#ratePerGm").blur(function(){ 
		$ratePerGm = $('#ratePerGm').val();		
		$netMetalBalance_roundoff = $billDetail.netMetalBalance;
		$totalCash = parseFloat($netMetalBalance_roundoff) * parseFloat($ratePerGm);
		
		$billDetail.ratePerGm = $ratePerGm;
		$billDetail.totalCash = toFixedTrunc($totalCash, 2);
		$('#totalCash').val($billDetail.totalCash);

		calculateNetMetalQuantity();
	});

	//Create Final Bill	
	$("#createFinalBill").click(function(){
		console.log('Close Bill Modal');
		$bill_customer_id = $('#bill_customer_id').val();
		$guestUserPhone = $('#guestUserPhone').val();
		$final_bill = 1;
		if(parseInt($bill_customer_id) == 0 && $guestUserPhone == ''){
			$('#customer_id_error').html('Please select Customer Name');
			$('#guestUserPhone_error').html('Please select Ph.No.');			
		}else{			
			calculateNetMetalQuantity();
			modalCustomer.style.display = "none";
			//closeCustomerModal();
		}
	});

	//Delete Bill	
	function deleteBill($bill_id){
		console.log('Delete Customer: '+$bill_id);
		if (confirm('Are you sure to delete the Bill?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteBill", bill_id: $bill_id }
			})
			.done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#bill_row_'+$bill_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	//////////////////// BILL FUNCTION END //////////////////////////

	//////////////////// Item Stock Start ///////////////////////////////
	$("#stock_item_id").change(function(){ 
		console.log('submit form here')
		$( "#itemstock_form" ).submit();
	});

	//Add stock
	$("#addItemStock").click(function(){
		console.log('select Item');

		$stock_item_id = $('#stock_item_id').val();
		$item_name = $("#stock_item_id option:selected").text();
		$stock_serial_no = $('#stock_serial_no').val();
		$stock_weight = $('#stock_weight').val();
		$raw_material_price = $('#raw_material_price').val();

		
		$('#stock_item_id_error').html('');
		$('#stock_serial_no_error').html('');
		$('#stock_weight_error').html('');
		$('#addItemStock_error').html('');
		
		if($stock_item_id == '0'){
			$('#stock_item_id_error').html('Please select Item');
		}else if($stock_serial_no == ''){
			$('#stock_serial_no_error').html('Please enter serial no');
		}else if($stock_weight == ''){
			$('#stock_weight_error').html('Please enter weight');			
		}else{
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "addItemStock", stock_item_id: $stock_item_id, stock_serial_no: $stock_serial_no, stock_weight: $stock_weight, raw_material_price: $raw_material_price }
			})
			.done(function( res ) {
				$res1 = JSON.parse(res);
				if($res1.status == true){	
					$stock_id = $res1.stock_id;
					$last_serial_no = $res1.last_serial_no;
					
					// $('#current_bill_id').val($current_bill_id);
					
					if(parseInt($stock_id) > 0){
						const table = $("#dataTable").DataTable();

						const tr = $("<tr id=stock_id_"+$stock_id+" style='font-weight: bold;'><td>"+$stock_id+"</td><td>"+$item_name+"</td><td>"+$stock_serial_no+"</td><td>"+$stock_weight+"</td><td>"+$raw_material_price+"</td><td> Available </td><td> <a class='btn btn-primary' onclick=editItemStock("+$stock_id+")>Edit</a> <a style='display: none;' class='btn btn-primary' onclick=updateItemStock("+$stock_id+")>Update</a> <a class='btn btn-danger' onclick=deleteItemStock("+$stock_id+")>Delete</a> </td></tr>");
						
						table.row.add(tr[0]).draw();

						$('#stock_serial_no').val($last_serial_no);
						$('#stock_weight').val('');
						$('#raw_material_price').val('');
						console.log('Stock Added Successfully');
						$('#addItemStock_error').html('Stock Added Successfully');
					}else{
						console.log('Serial no already exist');
						$('#addItemStock_error').html('Stock Add Error');
					}		
					
				}else{
					console.log('Serial no already exist');
					$('#addItemStock_error').html('Serial no already exist');
					
				}//end if
			});//end ajax
		}//end if
		
	});
	//end stock addfunction

	//Edit Item stock	
	function editItemStock($stock_id){
		console.log('Edit stock_id: '+$stock_id);	  
		$("#stock_serial_no_"+$stock_id).attr("type", "text");  
		$("#stock_weight_"+$stock_id).attr("type", "text"); 
		$("#raw_material_price_"+$stock_id).attr("type", "text");
		$('#update_'+$stock_id).css("display", "block"); 
		$('#edit_'+$stock_id).css("display", "none");
	}//end delete

	//Update Item stock	
	function updateItemStock($stock_id){
		console.log('Update stock_id: '+$stock_id); 

		$stock_serial_no = $('#stock_serial_no_'+$stock_id).val();
		$stock_weight = $('#stock_weight_'+$stock_id).val();
		$raw_material_price = $('#raw_material_price_'+$stock_id).val();

		$.ajax({
			method: "POST",
			url: "assets/php/function.php",
			data: { fn: "updateItemStock", stock_id: $stock_id, stock_serial_no: $stock_serial_no, stock_weight: $stock_weight, raw_material_price: $raw_material_price }
		})
		.done(function( res ) {
			console.log(res);
			$res1 = JSON.parse(res);
			if($res1.status == true){
				$('#stock_serial_no_txt_'+$stock_id).html($stock_serial_no);
				$('#stock_weight_txt_'+$stock_id).html($stock_weight);
				$('#raw_material_price_txt_'+$stock_id).html($raw_material_price);

				$('#stock_serial_no_'+$stock_id).val($stock_serial_no);
				$('#stock_weight_'+$stock_id).val($stock_weight);
				$('#raw_material_price_'+$stock_id).val($raw_material_price);

				$("#stock_serial_no_"+$stock_id).attr("type", "hidden");  
				$("#stock_weight_"+$stock_id).attr("type", "hidden");  
				$("#raw_material_price_"+$stock_id).attr("type", "hidden");
				$('#update_'+$stock_id).css("display", "none"); 
				$('#edit_'+$stock_id).css("display", "block"); 

			}
		});//end ajax
	}//end delete

	//Delete Item stock	
	function deleteItemStock($stock_id){
		console.log('Delete stock_id: '+$stock_id);
		if (confirm('Are you sure to delete the Stock?')) {
			$.ajax({
				method: "POST",
				url: "assets/php/function.php",
				data: { fn: "deleteItemStock", stock_id: $stock_id }
			})
			.done(function( res ) {
				console.log(res);
				$res1 = JSON.parse(res);
				if($res1.status == true){
					$('#stock_id_'+$stock_id).remove();
				}
			});//end ajax
		}		
	}//end delete

	//////////////////// Item Stock End ///////////////////////////////
	
	//Item Modal Popup Start
	var modal = document.getElementById("myModal");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}
	//Item Modal Popup end

	//Customer Modal Popup Start
	var modalCustomer = document.getElementById("myModalCustomer");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modalCustomer) {
		modalCustomer.style.display = "none";
	  }
	}
	//Customer Modal Popup end

	//MiniSlip Modal Popup Start
	var miniSlip = document.getElementById("miniSlip");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == miniSlip) {
		modalCustomer.style.display = "none";
	  }
	}
	//MiniSlip Modal Popup end

	//Bill Modal Popup Start
	var modalBill= document.getElementById("myModalBill");
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modalBill) {
		modalBill.style.display = "none";
	  }
	}
	//Bill Modal Popup end

	//Upto n th decimal without Round up
	function toFixedTrunc(x, n) {
		return x.toFixed(n);
		// const v = (typeof x === 'string' ? x : x.toString()).split('.');
		// if (n <= 0) return v[0];
		// let f = v[1] || '';
		// if (f.length > n) return `${v[0]}.${f.substr(0,n)}`;
		// while (f.length < n) f += '0';
		// return `${v[0]}.${f}`
	}

	
	//Loading screen
	$body = $("body");
	$(document).on({
		ajaxStart: function() { $body.addClass("loading");    },
		ajaxStop: function() { $body.removeClass("loading"); }    
	});
	
				
				