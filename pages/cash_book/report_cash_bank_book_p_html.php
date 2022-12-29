<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

    $message .="<head>";
        $message .="<meta charset='utf-8'>";
        $message .="<title>JEWELLERY - Bill</title>";
    $message .="</head>";
	
    $message .="<body >";
	
                        $message .="<table border='1' style='border-collapse:collapse;width: 100%;'>";
                                $message .="<thead>";
								
								$message .="<tr>";
									$message .="<th colspan='8' style='text-align: center;'>Jewellery Bill</th>";
								$message .="</tr>";
								
								$message .="<tr>";
									$message .="<th colspan='5' style='text-align: left;padding-left: 10px;'>
										<div>Monirul Islam</div>
										<div>Bill No: 271121_2006</div>
									</th>";
									$message .="<th colspan='3' style='text-align: right;padding-right: 10px;'>
										<div>10-March-2021</div>
										<div>2:51 pm</div>
									</th>";
								$message .="</tr>";
								
                                $message .="<tr>";
									$message .="<th> Sl#</th>";
									$message .="<th> Item</th>";
									$message .="<th>Weight</th>";
									$message .="<th>Less</th>";
									$message .="<th>Net Wt.</th>";
									$message .="<th>Tunch</th>";
									$message .="<th>Lab.</th>";									
									$message .="<th> Fine</th>";
								$message .="</tr>";
                                $message .="</thead>";

                                $message .="<tbody>";
								$message .="<tr>";
									$message .="<td style='text-align: center;'>1</td>";
									$message .="<td>66T Box</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>35.260</td>";
									$message .="<td>-</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>35.260</td>";
									$message .="<td>66.00 + 1.30</td>";
									$message .="<td>-</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>23.730</td>";
								$message .="</tr>";								
								
								$message .="<tr>";
									$message .="<td></td>";
									$message .="<td>New Total</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>35.260</td>";
									$message .="<td>-</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>35.260</td>";
									$message .="<td>-</td>";
									$message .="<td>-</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>23.730</td>";
								$message .="</tr>";								
								
								$message .="<tr>";
									$message .="<td></td>";
									$message .="<td colspan='6'>Old Balance (09-Mar-2021)</td>";
									$message .="<td></td>";
								$message .="</tr>";							
								
								$message .="<tr>";
									$message .="<td></td>";
									$message .="<td colspan='6' style='font-weight: bold;'>Total</td>";
									$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>23.730</td>";
								$message .="</tr>";						
								
								$message .="<tr>";
									$message .="<td colspan='8' style='text-align: center;font-weight: bold;''>Jama Details</td>";
								$message .="</tr>";							
								
								$message .="<tr>";
									$message .="<td></td>";
									$message .="<td>BREAD</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>25.570</td>";
									$message .="<td colspan='2' style='text-align: right; padding-right: 5px;'>25.570</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>99.50</td>";
									$message .="<td></td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>25.442</td>";
								$message .="</tr>";							
								
								$message .="<tr>";
									$message .="<td></td>";
									$message .="<td style='font-weight: bold;'>Jama Total</td>";
									$message .="<td style='text-align: right; padding-right: 5px;'>25.570</td>";
									$message .="<td colspan='2' style='text-align: right; padding-right: 5px;'>25.570</td>";
									$message .="<td></td>";
									$message .="<td></td>";
									$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>25.442</td>";
								$message .="</tr>";							
								
								$message .="<tr>";
									$message .="<td></td>";
									$message .="<td style='font-weight: bold;' colspan='6'>Bill Summary</td>";
									$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>-1.712</td>";
								$message .="</tr>";							
								
								$message .="<tr>";
									$message .="<td></td>";
									$message .="<td style='font-weight: bold;' colspan='6'>Final (JAMA)</td>";
									$message .="<td style='font-weight: bold;text-align: right; padding-right: 5px;'>-1.712</td>";
								$message .="</tr>";	
								
								 /*}else{ 
									$message .="<tr> ";
										$message .="<th colspan='12' >No Record Found </th>";
									$message .="</tr>";
								 }*/ 			
                                $message .="</tbody>";
                            $message .="</table>";


    $message .="</body>";
$message .="</html>";

?>