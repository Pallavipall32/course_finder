<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

include "../config.php";
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

$data = $paramList;
unset($data['CHECKSUMHASH']); 

if($isValidChecksum == "TRUE") {
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<script>alert('Transaction status is success')</script>";
	}
	else {
	
		echo "<script>alert('Transaction status is failure')</script>";
	}

	if (isset($_POST) && count($_POST)>0 )
	{ 
		print_r($data);
		insert("payments",$data);
		echo "<script>window.open('../index.php','_self')</script>";

	}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>