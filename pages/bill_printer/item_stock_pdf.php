<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['stock_item_id_report'])){
		$stock_item_id = $_GET['stock_item_id_report'];
		
		$sql = "SELECT item_stock_master.stock_id, item_stock_master.item_id, item_stock_master.stock_serial_no, item_stock_master.stock_weight, item_stock_master.raw_material_price, item_stock_master.stock_status, item_master.item_name FROM item_stock_master JOIN item_master ON item_stock_master.item_id = item_master.item_id WHERE item_stock_master.item_id = '".$stock_item_id."'";
		$result = $mysqli->query($sql);
	}
?>


<?php
// include autoloader
include('item_stock_html.php');
echo $message;

require_once '../../assets/dompdf/autoload.inc.php';

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
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream("jewellery_bill.pdf");

?>

<script>
window.print();
</script>