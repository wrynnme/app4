<?php require_once('../../Connections/ml.php'); ?>
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

$colname_search_shipment = "-1";
if (isset($_GET['id'])) {
  $colname_search_shipment = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_search_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_search_shipment, "int"));
$search_shipment = mysql_query($query_search_shipment, $ml) or die(mysql_error());
$row_search_shipment = mysql_fetch_assoc($search_shipment);
$totalRows_search_shipment = mysql_num_rows($search_shipment);
$txt0 = 0;
$row_limit = 110;

mysql_select_db($database_ml, $ml);
$query_search_drivermember = "SELECT * FROM drivermember WHERE driver_id =".$row_search_shipment['drivermember_id'];
$search_drivermember = mysql_query($query_search_drivermember, $ml) or die(mysql_error());
$row_search_drivermember = mysql_fetch_assoc($search_drivermember);
$totalRows_search_drivermember = mysql_num_rows($search_drivermember);

mysql_select_db($database_ml, $ml);
$query_search_customer = "SELECT * FROM customer WHERE id =".$row_search_shipment['customer_id'];
$search_customer = mysql_query($query_search_customer, $ml) or die(mysql_error());
$row_search_customer = mysql_fetch_assoc($search_customer);
$totalRows_search_customer = mysql_num_rows($search_customer);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
/* ############## ตรวจสอบค่า ###########################
echo $row_search_shipment['drivermember_id'];
echo $row_search_drivermember['driver_first_name'];
echo $row_search_drivermember['driver_last_name'];
echo $row_search_drivermember['driver_car_id'];
echo $row_search_customer['address1'];
echo $row_search_customer['address2'];
echo $row_search_customer['address3'];
echo $row_search_customer['address4'];
echo $row_search_customer['address5'];
echo $row_search_customer['postcode'];
echo $row_search_customer['telephone'];
echo $row_search_customer['faxnumber'];
###################################################### */

//require_once __DIR__ . '/vendor/autoload.php';
require_once '../../vendor/autoload.php';

//$mpdf->SetImportUse();
//$mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf([
	'format'			=> 'A4',
	'mode'			  => 'utf-8',
	'default_font_size' => '16',
	'default_font' 	  => 'thsarabun',
	]);


$txt2=  $row_search_customer['address1']."  ".
		$row_search_customer['address2']."  ".
		$row_search_customer['address3']."  ".
		$row_search_customer['address4']."  ".
		$row_search_customer['address5']."  ".
		$row_search_customer['postcode'];
		

$txt16 = "โทรศัพท์ ".$row_search_customer['telephone']."  "."โทรสาร ".$row_search_customer['faxnumber'];


$txt13 = $row_search_drivermember['driver_first_name']."  ".
		 $row_search_drivermember['driver_last_name'];


$mpdf->SetDocTemplate('templateshipment.pdf', 1);
//$mpdf->AddPage('L');
$txt0 = $txt0 + 1;

if ($row_search_shipment['customer_name'] <> ""){$txt1 = $row_search_shipment['customer_name'];}else {$txt1 = "";}
if ($txt2 == ""){$txt2 = " ";}
if ($row_search_shipment['customer_destination'] <> ""){$txt3 = $row_search_shipment['customer_destination'];}else {$txt3 = "";}

if ($row_search_shipment['product_payment_id'] <> ""){$txt4 = $row_search_shipment['product_payment_id'];}else {$txt4 = "";}
if ($row_search_shipment['product_dateout'] <> ""){$txt5 = $row_search_shipment['product_dateout'];}else {$txt5 = "";}
if ($row_search_shipment['po_number'] <> ""){$txt6 = $row_search_shipment['po_number'];}else {$txt6 = "ไม่มี";}
if ($row_search_shipment['order_number'] <> ""){$txt7 = $row_search_shipment['order_number'];}else {$txt7 = "ไม่มี";}
if ($row_search_shipment['ref_product_payment_id'] <> ""){$txt8 = $row_search_shipment['ref_product_payment_id'];}else {$txt8 = "";}
if ($row_search_shipment['type_product'] <> ""){$txt9 = $row_search_shipment['type_product'];}else {$txt9 = "";}
if ($row_search_shipment['product_amount2'] <> ""){$txt10 = $row_search_shipment['product_amount2'];}else {$txt10 = "";}
if ($row_search_shipment['product_amount'] <> ""){$txt11 = $row_search_shipment['product_amount'];}else {$txt11 = "";}
if ($row_search_shipment['comment3'] <> ""){$txt12 = $row_search_shipment['comment3'];}else {$txt12 = "";}
if ($txt13 == ""){$txt2 = " ";}
if ($row_search_drivermember['driver_car_id'] <> ""){$txt14 = $row_search_drivermember['driver_car_id'];}else {$txt14 = "";}
if ($row_search_shipment['date3'] <> ""){$txt15 = $row_search_shipment['date3'];}else {$txt15 = "";}
if ($row_search_shipment['customer_destination2'] <> ""){$txt17 = $row_search_shipment['customer_destination2'];}else {$txt17 = "";}



//วางตำแหน่งเอกสาร ###################################################
$mpdf->WriteFixedPosHTML(''.$txt1, 15, 43, 100, 90, 'auto');// ชื่อผู้สั่งสินค้า
$mpdf->WriteFixedPosHTML(''.$txt2, 15, 50, 150, 50, 'auto'); // ที่อยู่ผู้สั่งสินค้า
$mpdf->WriteFixedPosHTML($txt16, 15, 58, 150, 50, 'auto'); // หมายเลขติดต่อ
$mpdf->WriteFixedPosHTML($txt17, 90, 79, 100, 120, 'auto'); // เบอร์โทรศัพท์สถานที่ส่งสินค้า
$mpdf->WriteFixedPosHTML($txt3, 90, 88, 100, 120, 'auto'); // ชื่อย่อสถานที่ส่งสินค้า

$mpdf->WriteFixedPosHTML($txt5, 160, 60, 100, 120, 'auto'); // วันที่ขึ้นสินค้า
$mpdf->WriteFixedPosHTML('เลขที่เอกสาร : '.$txt4, 137, 65, 100, 120, 'auto'); // เลขที่เอกสาร
$mpdf->WriteFixedPosHTML('หมายเลขใบ PO : '.$txt6, 30, 208, 100, 120, 'auto'); // หมายเลขใบ PO
$mpdf->WriteFixedPosHTML('หมายเลขใบสั่งสินค้า : '.$txt7, 115, 208, 100, 120, 'auto'); // หมายเลขใบสั่งสินค้า

//ต้นฉบับข้อความ
$mpdf->WriteFixedPosHTML($txt0, 15, 110, 100, 120, 'auto'); // ลำดับที่
$mpdf->WriteFixedPosHTML($txt8, 45, 110, 100, 120, 'auto'); // เลขที่เอกสารอ้างอิงใบสั่งของ
$mpdf->WriteFixedPosHTML($txt9, 90, 110, 100, 120, 'auto'); // ชื่อสินค้า
$mpdf->WriteFixedPosHTML($txt10, 155, 110, 100, 120, 'auto'); // จำนวนถุง
$mpdf->WriteFixedPosHTML($txt11, 185, 110, 100, 120, 'auto'); // จำนวนตั้น
//จบต้นฉบับข้อความ

/* ต้นฉบับข้อความ 20 รายการต่อ 1 ใบ
for($i=1;$i<20;$i++){
$mpdf->WriteFixedPosHTML($txt0, 15, $row_limit, 100, 120, 'auto'); // ลำดับที่
$mpdf->WriteFixedPosHTML($txt8, 45, $row_limit, 100, 120, 'auto'); // เลขที่เอกสารอ้างอิงใบสั่งของ
$mpdf->WriteFixedPosHTML($txt9, 75, $row_limit, 100, 120, 'auto'); // ชื่อสินค้า
$mpdf->WriteFixedPosHTML($txt10, 155, $row_limit, 100, 120, 'auto'); // จำนวนถุง
$mpdf->WriteFixedPosHTML($txt11, 185, $row_limit, 100, 120, 'auto'); // จำนวนตั้น

$row_limit = $row_limit + 5;
}
จบต้นฉบับข้อความ */



//$mpdf->WriteFixedPosHTML($txt12, 15, 225, 180, 120, 'auto'); 
$mpdf->WriteFixedPosHTML($txt13, 145, 260, 100, 120, 'auto'); // ชื่อคนขับรถ
$mpdf->WriteFixedPosHTML($txt14, 145, 270, 100, 120, 'auto');// เลขทะเบียนรถ
$mpdf->WriteFixedPosHTML('(ป/ด/ว) '.$txt15, 145, 280, 100, 120, 'auto'); // วันที่ส่งสินค้า


$mpdf->Output('../shipment/fileupload/'.$txt4.'-1.pdf','F');
$mpdf->Output();




?>


</body>
</html>
<?php
mysql_free_result($search_shipment);

mysql_free_result($search_drivermember);

mysql_free_result($search_customer);
?>