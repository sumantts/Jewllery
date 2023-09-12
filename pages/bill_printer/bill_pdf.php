<?php
	include('../../assets/php/sql_conn.php');	
	ini_set('display_errors', 0);
	
	if(isset($_GET['bill_id'])){
		$bill_id = $_GET['bill_id'];
	}else{
		$firstKey = array_key_first($_REQUEST);
		$bill_id = $_REQUEST[$firstKey];
	}

	$sql_bill = "SELECT * FROM bill_details  WHERE bill_id = '" .$bill_id. "'";	
	$result_bill = $mysqli->query($sql_bill);
	$row_bill = $result_bill->fetch_array();
	$bill_description = json_decode(base64_decode($row_bill['bill_description']));

	//print_r($bill_description);
	$create_date = $row_bill['create_date'];
?>


<?php
// include autoloader
include('bill_html.php');
echo $message;

/*require_once '../../assets/dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->setDefaultFont('Courier');
$dompdf->setOptions($options);
$dompdf->loadHtml($message);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();*/

// Output the generated PDF to Browser
//$dompdf->stream("jewellery_bill.pdf");

?>

<script>
window.print();
</script>