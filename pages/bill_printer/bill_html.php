<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

$message .="<head>";
	$message .="<meta charset='utf-8'>";
	$message .="<title></title>";
$message .="</head>";

$message .="<body >";
	
$message .="<table border='1' style='border-collapse:collapse;width: 100%;'>";
		$message .="<thead>";
		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left;padding-left: 10px;'>";
			if($bill_description->customer_id > 0){
				$message .="<div>".$bill_description->customer_name."</div>";
			}else{
				$message .="<div>".$bill_description->customer_name." (".$bill_description->phone_number.")</div>";
			}
			$message .="<div>Bill No: ".$bill_description->billId."</div>
			</th>";
			$message .="<th colspan='2' style='text-align: right;padding-right: 10px;'>
				<div>".date('d-M-Y', strtotime($create_date))."</div>
				<div>".date('h: i a', strtotime($create_date))."</div>
			</th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th> Item</th>";
			$message .="<th>Weight</th>";
			$message .="<th>First Tunch</th>";
			$message .="<th>Second Tunch</th>";								
			$message .="<th> Fine</th>";
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";							
		
		$fineItems = $bill_description->fineItems;
		for($i = 0; $i < sizeof($fineItems); $i++){
			$message .="<tr>";
				$message .="<td style='padding-left: 5px;'>".$fineItems[$i]->item_name."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->item_weight."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->revised_first_tunch."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->revised_second_tunch."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->item_fine."</td>";
			$message .="</tr>";	
		}						
		
		$message .="<tr>";
			$message .="<td colspan='4' style='padding-left: 5px;'>Sub Total</td>";
			$message .="<td style='text-align: right; padding-right: 5px;'>".$bill_description->fineItemsSubTotal."</td>";
		$message .="</tr>";							
		
		$message .="<tr>";
			$message .="<td colspan='4' style='font-weight: bold; padding-left: 5px;'>Total (Sub Total ÷ 99.50)</td>";
			$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>".$bill_description->fineItemsTotalSubTotal."</td>";
		$message .="</tr>";			
		
		$message .="<tr>";
			$message .="<td colspan='4' style='padding-left: 5px;'>".$bill_description->metal_label." </td>";
			$message .="<td style='text-align: right; padding-right: 5px;'>".$bill_description->old_balance_metal."</td>";
		$message .="</tr>";	
		
		if($bill_description->metal_label == "Old balance(Metal Due)"){
			$afterAdjustment = $bill_description->fineItemsTotalSubTotal + $bill_description->old_balance_metal;
			$message .="<tr>";
				//$message .="<td colspan='4' style='font-weight: bold; padding-left: 5px;'>Total + ".$bill_description->metal_label." </td>";
				$message .="<td colspan='4' style='font-weight: bold; padding-left: 5px;'></td>";
				$message .="<td style='font-weight: bold; text-align: right; padding-right: 5px;'>".$afterAdjustment."</td>";
			$message .="</tr>";	
		}else{
			if($bill_description->old_balance_metal > 0){
				$afterAdjustment = $bill_description->fineItemsTotalSubTotal - $bill_description->old_balance_metal;
			}else{
				$afterAdjustment = 0;
			}
			$message .="<tr>";
	//$message .="<td colspan='4' style='font-weight: bold; padding-left: 5px;'>Total - ".$bill_description->metal_label."</td>";
				$message .="<td colspan='4' style='font-weight: bold; padding-left: 5px;'></td>";
				$message .="<td style='font-weight: bold; text-align: right; padding-right: 5px;'>".$afterAdjustment."</td>";
			$message .="</tr>";	
		}

		$message .="<tr>";
			$message .="<td colspan='5' style='text-align: center;font-weight: bold;'>Jama Details</td>";
		$message .="</tr>";							
		
		$jamaItems = $bill_description->jamaItems;
		for($j = 0; $j < sizeof($jamaItems); $j++){
			$message .="<tr>";
				$message .="<td style='padding-left: 5px;'>".$jamaItems[$j]->jama_item."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$jamaItems[$j]->jama_item_weight."</td>";
				$message .="<th></th>";
				$message .="<th></th>";								
				$message .="<th></th>";
			$message .="</tr>";	
		}						
		
		$message .="<tr>";
			$message .="<td style='font-weight: bold; padding-left: 5px;'>Jama Total</td>";
			$message .="<td style='text-align: right; padding-right: 5px;'>".$bill_description->jamaItemsSubTotal."</td>";
			$message .="<td></td>";
			$message .="<td></td>";
			$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>".$bill_description->jamaItemsSubTotal."</td>";
		$message .="</tr>";							
		
		$message .="<tr>";
			$message .="<td style='font-weight: bold; padding-left: 5px;' colspan='4'>(".$bill_description->netMetalBalanceType.")</td>";
			$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>".$bill_description->netMetalBalance."</td>";
		$message .="</tr>";							
		
		$message .="<tr>";
			if($bill_description->paymentType == 'due'){
				$message .="<td style='font-weight: bold; padding-left: 5px;' colspan='4'> (".$bill_description->paymentType.")</td>";
				$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>".$bill_description->netMetalBalance."</td>";
			}
			if($bill_description->paymentType == 'cash'){
				$message .="<td style='font-weight: bold; padding-left: 5px;' colspan='4'>(".$bill_description->paymentType.") (Rate/gm. ".$bill_description->ratePerGm." )</td>";
				$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>Rs. ".round($bill_description->totalCash, 2)."/-</td>";
			}
		$message .="</tr>";	

		$message .="</tbody>";
	$message .="</table>";


    $message .="</body>";
$message .="</html>";

?>