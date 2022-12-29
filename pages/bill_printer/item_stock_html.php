<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

$message .="<head>";
	$message .="<meta charset='utf-8'>";
	$message .="<title>JEWELLERY - Item Stock report</title>";
$message .="</head>";

$message .="<body>";
	
$message .="<table border='1' style='border-collapse:collapse;font-size: 16px;width: 100%;'>";
		$message .="<thead>";
		
		$message .="<tr>";
			$message .="<th colspan='5' style='text-align: center;'>JEWELLERY - Item Stock report of ".date('d-M-Y')."</th>";
		$message .="</tr>";
		
		
		$message .="<tr>";
			$message .="<th> Sl.No.</th>";
			$message .="<th>Item Name</th>";
			$message .="<th>Serial Number</th>";								
			$message .="<th>Weight(Available)</th>";								
			$message .="<th>Weight(Soldout)</th>";								
			$message .="<th>Raw Material Price(Available)</th>";							
			$message .="<th>Raw Material Price(Soldout)</th>";									
			$message .="<th>Status</th>";	
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";							
		
		$a = 0; $b = 0; $c = 0; $d = 0; $e = 0; $f = 0; $i = 0;
		while ($row_stock = $result->fetch_array()){ 
			$i++;
			$item_name = $row_stock['item_name'];
			$stock_serial_no = $row_stock['stock_serial_no'];
			$stock_weight = $row_stock['stock_weight'];
			$raw_material_price = $row_stock['raw_material_price'];
			$available_stock_weight = 0.000;
			$soldout_stock_weight = 0.000;

			$raw_material_price_available = 0;
			$raw_material_price_soldout = 0;
			
			if($row_stock['stock_status'] == 1){ 
				$stock_status_text = "Available";
				$available_stock_weight = $stock_weight;
				$a = $a + $stock_weight;
				$raw_material_price_available = $raw_material_price;
				$f = $f + $raw_material_price_available;
				$c++;
			}else{
				$stock_status_text = "Sold Out";
				$soldout_stock_weight = $stock_weight;
				$b = $b + $stock_weight;
				$raw_material_price_soldout = $raw_material_price;
				$e = $e + $raw_material_price_soldout;
				$d++;
			}
			

			$message .="<tr>";
				$message .="<td style='padding-left: 5px;'>".$i."</td>";
				$message .="<td>".$item_name."</td>";
				$message .="<td>". $stock_serial_no ."</td>";
				$message .="<td style='text-align: right;'>".$available_stock_weight."</td>";
				$message .="<td style='text-align: right;'>".$soldout_stock_weight."</td>";
				$message .="<td style='text-align: right;'>".$raw_material_price_available."</td>";
				$message .="<td style='text-align: right;'>".$raw_material_price_soldout."</td>";
				$message .="<td>".$stock_status_text."</td>";				
			$message .="</tr>";	
				
		}						
		
		$message .="<tr>";
			$message .="<td colspan='3' style='text-align: center; padding-left: 5px; font-weight: bold;'>Total Available: ".$c." Pcs. Total Soldout: ".$d." Pcs. </td> <td style='text-align: right; font-weight: bold;'>".number_format((float)$a, 3, '.', '')."</td><td style='text-align: right; font-weight: bold;'>".number_format((float)$b, 3, '.', '')."</td><td style='text-align: right; font-weight: bold;'>".number_format((float)$f, 2, '.', '')."</td><td style='text-align: right; font-weight: bold;'>".number_format((float)$e, 2, '.', '')."</td><td>&nbsp;</td>";
		$message .="</tr>";	

		$message .="</tbody>";
	$message .="</table>";
    $message .="</body>";
$message .="</html>";

?>