<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

    $start_date_time = date('Y-m-d').' 00:00:00';
    $end_date_time = date('Y-m-d').' 23:59:59';

    //$sql_bill = "SELECT * FROM bill_details WHERE create_date >= '" .$start_date_time. "' AND create_date <= '" .$end_date_time. "' ORDER BY bill_id DESC  LIMIT 0, 10";	
    $sql_bill = "SELECT * FROM bill_details WHERE create_date >= '" .$start_date_time. "' AND create_date <= '" .$end_date_time. "' ORDER BY bill_id DESC";	
	$result_bill = $mysqli->query($sql_bill);

	?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"><?=$title?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Today's summary report</li>
                        </ol>
						
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Customer's Name</th>
                            <th scope="col">Customer's Ph.No.</th>
                            <th scope="col">Fine(After 99.50)</th>
                            <th scope="col">Jama</th>
                            <th scope="col">Bill Summary</th>
                            <th scope="col">Due</th>
                            <th scope="col">Cash</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;

                        $subTotalfineItemsTotalSubTotal = 0;
                        $subTotaljamaItemsSubTotal = 0;
                        $subTotalnetMetalBalance = 0;
                        $subTotaltotalCash = 0; 

                        while ($row_bill = $result_bill->fetch_array()){ 
                            $i++;
                            $bill_id = $row_bill['bill_id'];
                            $bill_description = json_decode(base64_decode($row_bill['bill_description']));
                            
                            $fineItemsTotalSubTotal = $bill_description->fineItemsTotalSubTotal;
                            $jamaItemsSubTotal = $bill_description->jamaItemsSubTotal;
                            $netMetalBalance = $bill_description->netMetalBalance;
                            $netMetalBalance = $bill_description->netMetalBalance;
                            $totalCash = $bill_description->totalCash;

                            $subTotalfineItemsTotalSubTotal = ($subTotalfineItemsTotalSubTotal + $fineItemsTotalSubTotal);
                            $subTotaljamaItemsSubTotal = ($subTotaljamaItemsSubTotal + $jamaItemsSubTotal);
                            $subTotalnetMetalBalance = ($subTotalnetMetalBalance + $netMetalBalance);
                            $subTotaltotalCash = ($subTotaltotalCash + $totalCash);

                        ?>
                            <tr>
                            <th scope="row"><?=$i?></th>
                            <td><?=$bill_description->customer_name?></td>
                            <td><?=$bill_description->phone_number?></td>
                            <td style="text-align: right;"><?=$fineItemsTotalSubTotal?></td>
                            <td style="text-align: right;"><?=$jamaItemsSubTotal?></td>
                            <td style="text-align: right;"><?=$netMetalBalance?></td>
                            <td style="text-align: right;"><?=$netMetalBalance?></td>
                            <td style="text-align: right;"><?=$totalCash?></td>
                            </tr>
                        <?php } ?> 
                        </tbody>
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col" colspan="2">Total</th>
                            <th scope="col" style="text-align: right;"><?=$subTotalfineItemsTotalSubTotal?></th>
                            <th scope="col" style="text-align: right;"><?=$subTotaljamaItemsSubTotal?></th>
                            <th scope="col" style="text-align: right;"><?=$subTotalnetMetalBalance?></th>
                            <th scope="col" style="text-align: right;"><?=$subTotalnetMetalBalance?></th>
                            <th scope="col" style="text-align: right;"><?=$subTotaltotalCash?></th>
                            </tr>
                        </thead>
                        </table>

                        </div>
                    </div>
                </main>

				
				<?php include('common/footer.php'); ?>