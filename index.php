<?php
	include('assets/php/sql_conn.php');	
	
	if(isset($_GET["p"])){
		$p = $_GET["p"];
	}else{
		$p = '';
	}
	
	switch($p){
		case 'login':
		include('pages/login.php');
		break;
		
		case 'dashboard':
		$title = "Dashboard";
		include('pages/dashboard.php');		
		break;
		
		case 'dashboard-all':
		$title = "Dashboard All";
		include('pages/dashboard-all.php');		
		break;
		
		case 'items':
		$title = "Items";
		include('pages/items.php');		
		break;
		
		case 'customers':
		$title = "Customers";
		include('pages/customers.php');		
		break;
		
		case 'todays-bill':
		$title = "Today's Bill";
		include('pages/todays_bill.php');		
		break;
		
		case 'bill':
		$title = "Bill List";
		include('pages/bill.php');		
		break;
		
		case 'new_bill':
		$title = "New Bill";
		include('pages/new_bill.php');		
		break;
		
		case 'item_stock':
		$title = "Item Stock";
		include('pages/item_stock.php');		
		break;
		
		case 'item_stock_report':
		$title = "Item Stock Report";
		include('pages/item_stock_report.php');		
		break;
				
		default:
		include('pages/login.php');
	}

	//New code update for this branch

?>