<?php require_once('../../Connections/ml.php'); ?>
<?php
	include ("baht_text.php");
	## วิธีใช้งาน
	//$x = '9123568543241.25'; 
	//echo  $x  . "=>" .convert($x); 
 ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_listreceipt = 9999;
$pageNum_listreceipt = 0;
if (isset($_GET['pageNum_listreceipt'])) {
  $pageNum_listreceipt = $_GET['pageNum_listreceipt'];
}
$startRow_listreceipt = $pageNum_listreceipt * $maxRows_listreceipt;

$colname_listreceipt = "-1";
if (isset($_GET['billing_id'])) {
  $colname_listreceipt = $_GET['billing_id'];
}
mysql_select_db($database_ml, $ml);
$query_listreceipt = sprintf("SELECT * FROM receipt WHERE billing_id = %s", GetSQLValueString($colname_listreceipt, "text"));
$query_limit_listreceipt = sprintf("%s LIMIT %d, %d", $query_listreceipt, $startRow_listreceipt, $maxRows_listreceipt);
$listreceipt = mysql_query($query_limit_listreceipt, $ml) or die(mysql_error());
$row_listreceipt = mysql_fetch_assoc($listreceipt);

if (isset($_GET['totalRows_listreceipt'])) {
  $totalRows_listreceipt = $_GET['totalRows_listreceipt'];
} else {
  $all_listreceipt = mysql_query($query_listreceipt);
  $totalRows_listreceipt = mysql_num_rows($all_listreceipt);
}
$totalPages_listreceipt = ceil($totalRows_listreceipt/$maxRows_listreceipt)-1;


mysql_select_db($database_ml, $ml);
$query_listcostomer = "SELECT * FROM customer WHERE id = ".$row_listreceipt['customer_id'];
$listcostomer = mysql_query($query_listcostomer, $ml) or die(mysql_error());
$row_listcostomer = mysql_fetch_assoc($listcostomer);
$totalRows_listcostomer = mysql_num_rows($listcostomer);

?>
<?php
if ($totalRows_listreceipt > 1)
	{
		$txt0 = 0;
	}
else
	{
		
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>พิมพ์ใบเสร็จ</title>
</head>

<body>
<?php //echo "hello"; ?>
  <?php 

require_once '../../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
	'format'			=> 'A4',
	'mode'			  => 'utf-8',
	'default_font_size' => '12',
	'default_font' 	  => 'thsarabun',
	]);

//ข้อมูลทำใบเสร็จ ส่วนหัวกระดาษ
$new_status = 3; //กำหนดสถานะว่าพิมพ์ใบเสร็จแล้ว
$receipt_bill_no = "THE".date("dmYHsi")."-4"; //เลขที่ใบเสร็จ
$fileupload = $receipt_bill_no.".pdf"; //กำหนดชื่อไฟล์ใบเสร็จ
//$date_receipt_bill_out = date("d / m / Y"); // วันที่ออกใบเสร็จ
$date_receipt_bill_out = $_GET["txt_date_receipt"]; // วันที่ออกใบเสร็จ
$billing_no = $_GET['billing_id']; // เลขอ้างอิงใบแจ้งหนี้

$customer_name = $row_listcostomer['name'];
$customer_address=  $row_listcostomer['address1']."  ".
					$row_listcostomer['address2']."  ".
					$row_listcostomer['address3']."  ".
					$row_listcostomer['address4']."  ".
					$row_listcostomer['address5']."  ".
					$row_listcostomer['postcode'];
$customer_tax_customer_id =$row_listcostomer['tax_customer_id'];
$customer_telephone =$row_listcostomer['telephone'];
$customer_faxnumber =$row_listcostomer['faxnumber'];
//จบข้อมูลทำใบเสร็จ ส่วนหัวกระดาษ

//คำนวนค่าขนส่งรวมทั้งหมดจากข้อมูลย่อยของแต่ละใบส่งสินค้าที่มีหมายเลขใบแจ้งหนี้เดียวกัน
do { 
	
	$totalamount = $totalamount +  $row_listreceipt['amount']; //ยอดรวมทุกบิลย่อย
	$totalamount2 = $totalamount2 + $row_listreceipt['amount2']; //ยอดรวมค่าขนส่งเพิ่มทุกบิลย่อย
	$totalall = $totalamount + $totalamount2;
	$txtdatet = $row_listreceipt['round_shipment'];
	
	//UPdate ข้อมูลเลขที่ใบแจ้งหนี้ในตารางใบเสร็จ
	$update1SQL = sprintf("UPDATE receipt SET receipt_id=%s, receipt_date=%s WHERE billing_id=%s",
					   GetSQLValueString($receipt_bill_no, "text"),
					   GetSQLValueString(date("Y/m/d"), "date"),
					   GetSQLValueString($billing_no, "text"));				   
	mysql_select_db($database_ml, $ml);
	$Result1 = mysql_query($update1SQL, $ml) or die(mysql_error());
	//จบ UPdate ข้อมูลเลขที่ใบแจ้งหนี้ในตารางใบเสร็จ
	
	//ปรับสถานะเอกสารเป็นรอพิมพ์ใบเสร็จรับเงิน
	mysql_select_db($database_ml, $ml);
	$query_shipment = "SELECT * FROM shipment WHERE id = ".$row_listreceipt['shipment_id'];
	$listshipment = mysql_query($query_shipment, $ml) or die(mysql_error());
	$row_listshipment = mysql_fetch_assoc($listshipment);
	if ($row_listshipment['status'] == 4){$new_status = $row_listshipment['status'];}	
	$update2SQL = sprintf("UPDATE shipment SET picturestatus4=%s , status=%s WHERE id=%s",
			GetSQLValueString($fileupload, "text"),
			GetSQLValueString($new_status, "int"),
			GetSQLValueString($row_listreceipt['shipment_id'], "int"));					   
	mysql_select_db($database_ml, $ml);
	$Result1 = mysql_query($update2SQL, $ml) or die(mysql_error());
	//จบปรับสถานะเอกสารเป็นรอพิมพ์ใบเสร็จรับเงิน
} while ($row_listreceipt = mysql_fetch_assoc($listreceipt)); 
//จบ คำนวนค่าขนส่งรวมทั้งหมดจากข้อมูลย่อยของแต่ละใบส่งสินค้าที่มีหมายเลขใบแจ้งหนี้เดียวกัน

$mpdf->SetDocTemplate('templatereceipt.pdf', 1);

//$txt0 = $txt0 + 1;


//วางตำแหน่งเอกสาร หัวกระดาษ ###################################################
$mpdf->WriteFixedPosHTML($receipt_bill_no, 175, 17, 100, 120, 'auto'); // เลขที่ใบเสร็จ
$mpdf->WriteFixedPosHTML($date_receipt_bill_out, 175, 24, 100, 120, 'auto'); // วันที่ออกใบเสร็จ
$mpdf->WriteFixedPosHTML($billing_no, 175, 31, 200, 10, 'auto'); // หมายเลขใบวางบิล

$mpdf->WriteFixedPosHTML($customer_name, 50, 52, 200, 10, 'auto'); // ชื่อลูกค้า
$mpdf->WriteFixedPosHTML($customer_address, 50, 59, 200, 120, 'auto'); // ที่อยู่ลูกค้า
$mpdf->WriteFixedPosHTML($customer_tax_customer_id, 50, 65, 100, 120, 'auto'); // หมายเลขประจำตัวผู้เสียภาษีลูกค้า
$mpdf->WriteFixedPosHTML(' หมายเลขโทรศัพท์ '.$customer_telephone.' / หมายเลขโทรสาร '.$customer_faxnumber, 50, 71, 100, 120, 'auto'); // เบอร์โทรติดต่อลูกค้า

//$mpdf->Output();
//จบ วางตำแหน่งเอกสาร หัวกระดาษ ###################################################


$txt0 = $txt0 + 1;
$totalamount_txt = baht_text($totalall);
//วางตำแหน่งเอกสาร รายการบิล ###################################################
$mpdf->WriteFixedPosHTML($txt0, 15, 90, 100, 120, 'auto'); // ลำดับที่
$mpdf->WriteFixedPosHTML('ค่าขนส่ง', 78, 90, 100, 120, 'auto'); // ลำดับรายการ
$mpdf->WriteFixedPosHTML($txtdatet, 78, 97, 100, 120, 'auto'); // รอบการขนส่ง
$mpdf->WriteFixedPosHTML(number_format($totalall,2), 178, 90, 100, 120, 'auto'); // จำนวนเงิน
$mpdf->WriteFixedPosHTML(number_format($totalall,2), 178, 179, 100, 120, 'auto'); // ยอดรวม
$mpdf->WriteFixedPosHTML(number_format($totalall,2), 178, 187, 100, 120, 'auto'); // ยอดสุทธิ
$mpdf->WriteFixedPosHTML('   ( '.$totalamount_txt.' )   ', 50, 187, 100, 120, 'auto'); // ข้อความรวมภาษาไทย

//จบ วางตำแหน่งเอกสาร รายการบิล ###################################################


$mpdf->Output('../shipment/fileupload/'.$fileupload,'F');
$mpdf->Output();

?>
  


</body>
</html>
<?php
//mysql_free_result($listreceipt);
//mysql_free_result($listcostomer);
?>