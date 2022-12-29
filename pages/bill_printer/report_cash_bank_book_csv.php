<?php
	include('../../assets/php/sql_conn.php');
	
	if(isset($_POST["start_date_cb_csv"]) && $_POST["start_date_cb_csv"] != ''){
		$return_result = array();
		
		$user_CSV = array();
		$user_CSV[0] = array('Date', 'Receipt No', 'From whom Recd & Purpose', 'Head of Account', 'Cash (Rs.)', 'Bank (Rs.)', 'Date', 'Voucher No', 'To whom paid & Purpose/Cheque No.', 'Head of Account', 'Cash (Rs.)', 'Bank(Rs.)');
		
		$user_id = $_POST["user_id_cb"];		
		$institute_id = $_POST["institute_id_cb"];//social id
		$start_date = date('Y/m/d', strtotime($_POST["start_date_cb_csv"]));	
		$end_date = date('Y/m/d', strtotime($_POST["end_date_cb_csv"]));
		
		$status = true;
		
		$v = "'".$institute_id."','".$start_date."','".$end_date."'";	
		
		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			$sql = 'CALL usp_rptCashBook('.$v.')';
			$q = $pdo->query($sql);
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$cashbook_arr = array();
			
			$TotalRcptCashAmt = 0;
			$TotalRcptBankAmt = 0;
			$TotalPaymtCashAmt = 0;
			$TotalPaymtBankAmt = 0;
			
			$GrandTotalRcptCashAmt = 0;
			$GrandTotalRcptBankAmt = 0;
			$GrandTotalPaymtCashAmt = 0;
			$GrandTotalPaymtBankAmt = 0;
			
			
			
			while($r = $q->fetch()){
				$cashbook_obj = new stdClass();
				$csv_data = array();
				
				if($r['RcptDt'] == null){
					$cashbook_obj->RcptDt = '';
					$RcptDt = '';
				}else{
					$cashbook_obj->RcptDt = date('d-m-Y', strtotime($r['RcptDt']));
					$RcptDt = date('d-m-Y', strtotime($r['RcptDt']));
				}
				$cashbook_obj->RcptNo = ($r['RcptNo'] == null)? '': $r['RcptNo'];
				$RcptNo = ($r['RcptNo'] == null)? '': $r['RcptNo'];
				
				$cashbook_obj->RcptParticulars = ($r['RcptParticulars'] == null)? '': $r['RcptParticulars'];
				$RcptParticulars = ($r['RcptParticulars'] == null)? '': $r['RcptParticulars'];
				
				$cashbook_obj->RcptGlNm = ($r['RcptGlNm'] == null)? '': $r['RcptGlNm'];
				$RcptGlNm = ($r['RcptGlNm'] == null)? '': $r['RcptGlNm'];
				
				$cashbook_obj->RcptCashAmt = ($r['RcptCashAmt'] == null)? '': $r['RcptCashAmt'];
				$RcptCashAmt = ($r['RcptCashAmt'] == null)? '': $r['RcptCashAmt'];
				
				$cashbook_obj->RcptBankAmt = ($r['RcptBankAmt'] == null)? '': $r['RcptBankAmt'];
				$RcptBankAmt = ($r['RcptBankAmt'] == null)? '': $r['RcptBankAmt'];
				
				if($r['PaymtDt'] == null){
					$cashbook_obj->PymtDt = '';
					$PymtDt = '';
				}else{
					$cashbook_obj->PymtDt = date('d-m-Y', strtotime($r['PaymtDt']));
					$PymtDt = date('d-m-Y', strtotime($r['PaymtDt']));
				}
				
				$cashbook_obj->PaymtNo = ($r['PaymtNo'] == null)? '': $r['PaymtNo'];
				$PaymtNo = ($r['PaymtNo'] == null)? '': $r['PaymtNo'];

				$cashbook_obj->PaymtParticulars = ($r['PaymtParticulars'] == null)? '': $r['PaymtParticulars'];
				$PaymtParticulars = ($r['PaymtParticulars'] == null)? '': $r['PaymtParticulars'];
				
				$cashbook_obj->PaymtGlNm = ($r['PaymtGlNm'] == null)? '': $r['PaymtGlNm'];
				$PaymtGlNm = ($r['PaymtGlNm'] == null)? '': $r['PaymtGlNm'];
				
				$cashbook_obj->PaymtCashAmt = ($r['PaymtCashAmt'] == null)? '': $r['PaymtCashAmt'];
				$PaymtCashAmt = ($r['PaymtCashAmt'] == null)? '': $r['PaymtCashAmt'];
				
				$cashbook_obj->PaymtBankAmt = ($r['PaymtBankAmt'] == null)? '': $r['PaymtBankAmt'];
				$PaymtBankAmt = ($r['PaymtBankAmt'] == null)? '': $r['PaymtBankAmt'];
				
				array_push($cashbook_arr, $cashbook_obj);
				
				if($RcptCashAmt){							
					$TotalRcptCashAmt = $TotalRcptCashAmt + $RcptCashAmt;
				}
				if($RcptBankAmt){							
					$TotalRcptBankAmt = $TotalRcptBankAmt + $RcptBankAmt;
				}
				if($PaymtCashAmt){							
					$TotalPaymtCashAmt = $TotalPaymtCashAmt + $PaymtCashAmt;
				}
				if($PaymtBankAmt){							
					$TotalPaymtBankAmt = $TotalPaymtBankAmt + $PaymtBankAmt;
				}
				
				$csv_data[0] = $RcptDt;
				$csv_data[1] = $RcptNo;
				$csv_data[2] = $RcptParticulars;
				$csv_data[3] = $RcptGlNm;
				$csv_data[4] = $RcptCashAmt;
				$csv_data[5] = $RcptBankAmt;
				$csv_data[6] = $PymtDt;
				$csv_data[7] = $PaymtNo;
				$csv_data[8] = $PaymtParticulars;
				$csv_data[9] = $PaymtGlNm;
				$csv_data[10] = $PaymtCashAmt;
				$csv_data[11] = $PaymtBankAmt;
				
				array_push($user_CSV, $csv_data);
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
			$openingBalanceCash = $return_result['openingBalanceCash'];
			
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
			$openingBalanceBank = $return_result['openingBalanceBank'];
			
			
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
			$closeingBalanceCash = $return_result['closeingBalanceCash'];
			
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
			$closeingBalanceBank = $return_result['closeingBalanceBank'];
			
			$GrandTotalRcptCashAmt = $TotalRcptCashAmt + $openingBalanceCash;
			$GrandTotalRcptBankAmt = $TotalRcptBankAmt + $openingBalanceBank;
			$GrandTotalPaymtCashAmt = $TotalPaymtCashAmt + $closeingBalanceCash;
			$GrandTotalPaymtBankAmt = $TotalPaymtBankAmt + $closeingBalanceBank;
			
			$TotalRcptCashAmt1 = number_format($TotalRcptCashAmt, 2);
			$TotalRcptBankAmt1 = number_format($TotalRcptBankAmt, 2);
			$TotalPaymtCashAmt1 = number_format($TotalPaymtCashAmt, 2);
			$TotalPaymtBankAmt1 = number_format($TotalPaymtBankAmt, 2);
			
			$user_CSV_temp = array('', '', '', 'Total Receipt', $TotalRcptCashAmt1, $TotalRcptBankAmt1, '', '', '', 'Total Payment', $TotalPaymtCashAmt1, $TotalPaymtBankAmt1);			
			array_push($user_CSV, $user_CSV_temp);
			
			$openingBalanceCash1 = number_format($openingBalanceCash, 2);
			$openingBalanceBank1 = number_format($openingBalanceBank, 2);
			$closeingBalanceCash1 = number_format($closeingBalanceCash, 2);
			$closeingBalanceBank1 = number_format($closeingBalanceBank, 2);
			$user_CSV_temp1 = array('', '', '', 'Opening Balance', $openingBalanceCash1, $openingBalanceBank1, '', '', '', 'Closing Balance', $closeingBalanceCash1, $closeingBalanceBank1);			
			array_push($user_CSV, $user_CSV_temp1);
			
			$GrandTotalRcptCashAmt1 = number_format($GrandTotalRcptCashAmt, 2);
			$GrandTotalRcptBankAmt1 = number_format($GrandTotalRcptBankAmt, 2);
			$GrandTotalPaymtCashAmt1 = number_format($GrandTotalPaymtCashAmt, 2);
			$GrandTotalPaymtBankAmt1 = number_format($GrandTotalPaymtBankAmt, 2);
			$user_CSV_temp2 = array('', '', '', 'Grand Total', $GrandTotalRcptCashAmt1, $GrandTotalRcptBankAmt1, '', '', '', 'Grand Total', $GrandTotalPaymtCashAmt1, $GrandTotalPaymtBankAmt1);			
			array_push($user_CSV, $user_CSV_temp2);
			
		} catch (PDOException $e) {
			die("Error occurred:" . $e->getMessage());
		}	
		$return_result['status'] = $status;
		
		//echo json_encode($return_result);		
		//echo json_encode($user_CSV);
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="cash_book.csv"');		

		// very simple to increment with i++ if looping through a database result 
		//$user_CSV[1] = array('Quentin', 'Del Viento', 34);
		

		$fp = fopen('php://output', 'wb');
		foreach ($user_CSV as $line) {
			// though CSV stands for "comma separated value"
			// in many countries (including France) separator is ";"
			fputcsv($fp, $line, ',');
		}
		fclose($fp);
	}//end isset
	