<?php
	include('../../assets/php/sql_conn.php');
	/*$return_result = array();
		if(isset($_POST["user_id_cb"])){
		$user_id = $_POST["user_id_cb"];		
		$institute_id = $_POST["institute_id_cb"];//social id
		$start_date = date('Y/m/d', strtotime($_POST["start_date"]));	
		$end_date = date('Y/m/d', strtotime($_POST["end_date"]));
		
		$status = true;
		
		$v = "'".$institute_id."','".$start_date."','".$end_date."'";	
		
		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$sql = 'CALL usp_rptCashBook('.$v.')';
			$q = $pdo->query($sql);
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$cashbook_arr = array();
			while($r = $q->fetch()){
				$cashbook_obj = new stdClass();
				if($r['RcptDt'] == null){
					$cashbook_obj->RcptDt = '';
				}else{
					$cashbook_obj->RcptDt = date('d-m-Y', strtotime($r['RcptDt']));
				}
				$cashbook_obj->RcptNo = ($r['RcptNo'] == null)? '': $r['RcptNo'];
				$cashbook_obj->RcptParticulars = ($r['RcptParticulars'] == null)? '': $r['RcptParticulars'];
				$cashbook_obj->RcptGlNm = ($r['RcptGlNm'] == null)? '': $r['RcptGlNm'];
				$cashbook_obj->RcptCashAmt = ($r['RcptCashAmt'] == null)? '': $r['RcptCashAmt'];
				$cashbook_obj->RcptBankAmt = ($r['RcptBankAmt'] == null)? '': $r['RcptBankAmt'];
				if($r['PaymtDt'] == null){
					$cashbook_obj->PymtDt = '';
				}else{
					$cashbook_obj->PymtDt = date('d-m-Y', strtotime($r['PaymtDt']));
				}
				$cashbook_obj->PaymtNo = ($r['PaymtNo'] == null)? '': $r['PaymtNo'];				
				$cashbook_obj->PaymtParticulars = ($r['PaymtParticulars'] == null)? '': $r['PaymtParticulars'];
				$cashbook_obj->PaymtGlNm = ($r['PaymtGlNm'] == null)? '': $r['PaymtGlNm'];
				$cashbook_obj->PaymtCashAmt = ($r['PaymtCashAmt'] == null)? '': $r['PaymtCashAmt'];
				$cashbook_obj->PaymtBankAmt = ($r['PaymtBankAmt'] == null)? '': $r['PaymtBankAmt'];
				array_push($cashbook_arr, $cashbook_obj);
			}
			
			$return_result['cashbook_arr'] = $cashbook_arr;
			$return_result['cashbook_arr_size'] = sizeof($cashbook_arr);
			
			//2. Opening Balance Cash
			$prmType = 'O';
			$pdo1 = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$v1 = "'".$institute_id."','".$prmType."','".$start_date."',@return";
			$sql1 = 'CALL usp_getCashBalance('.$v1.')';
			$q1 = $pdo1->query($sql1);
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			
			$q1 = $pdo1->query('SELECT @return');
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			$r1 = $q1->fetch();
			$return_result['openingBalanceCash'] = $r1["@return"];
			
			//2. Opening Balance Bank
			$prmType = 'O';
			$pdo1 = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$v1 = "'".$institute_id."','".$prmType."','".$start_date."',@return";
			$sql1 = 'CALL usp_getBankBalance('.$v1.')';
			$q1 = $pdo1->query($sql1);
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			
			$q1 = $pdo1->query('SELECT @return');
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			$r1 = $q1->fetch();
			$return_result['openingBalanceBank'] = $r1["@return"];
			
			
			//2. Closing Balance Cash
			$prmType = 'C';
			$pdo1 = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$v1 = "'".$institute_id."','".$prmType."','".$end_date."',@return";
			$sql1 = 'CALL usp_getCashBalance('.$v1.')';
			$q1 = $pdo1->query($sql1);
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			
			$q1 = $pdo1->query('SELECT @return');
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			$r1 = $q1->fetch();
			$return_result['closeingBalanceCash'] = $r1["@return"];
			
			//2. Closing Balance Bank
			$prmType = 'C';
			$pdo1 = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$v1 = "'".$institute_id."','".$prmType."','".$end_date."',@return";
			$sql1 = 'CALL usp_getBankBalance('.$v1.')';
			$q1 = $pdo1->query($sql1);
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			
			$q1 = $pdo1->query('SELECT @return');
			$q1->setFetchMode(PDO::FETCH_ASSOC);
			$r1 = $q1->fetch();
			$return_result['closeingBalanceBank'] = $r1["@return"];
			
		} catch (PDOException $e) {
			die("Error occurred:" . $e->getMessage());
		}	
		$return_result['status'] = $status;
		}//end isset
		//echo json_encode($return_result);*/
		

?>


<?php
// include autoloader
include('report_cash_bank_book_p_html.php');
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