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

$colname_search_customer = "-1";
//if (isset($_GET['id'])) {
//  $colname_search_customer = $_GET['id'];
if (isset($row_search_shipment['customer_id'])) {
  $colname_search_customer = $row_search_shipment['customer_id'];
}
mysql_select_db($database_ml, $ml);
$query_search_customer = sprintf("SELECT * FROM customer WHERE id = %s", GetSQLValueString($colname_search_customer, "int"));
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

<!--<p>id = <?php //echo $row_search_shipment['id']; ?><br>
วันที่ขึ้นสินค้า = <?php //echo $row_search_shipment['product_dateout']; ?><br>
เลขที่เอกสาร = <?php //echo $row_search_shipment['product_payment_id']; ?><br>
หมายเลขตั๋วสินค้า = <?php //echo $row_search_shipment['ref_product_payment_id']; ?><br>
รายการสินค้า = <?php //echo $row_search_shipment['type_product']; ?><br>
จำนวน (ตัน) = <?php //echo $row_search_shipment['product_amount']; ?><br>
ชื่อผู้ซื้อ / ที่อยู่ / เบอร์โทร =<?php //echo $row_search_customer['name']; ?> / เบอร์โทรศัพท์ <?php //echo $row_search_customer['telephone']; ?> / โทรสาร <?php //echo $row_search_customer['faxnumber']; ?><br>
ที่อยู่เพื่อจัดส่ง = <?php //echo $row_search_shipment['customer_destination']; ?><br>
</p> -->
<?php 
//require_once __DIR__ . '/vendor/autoload.php';
require_once '../../vendor/autoload.php';

//$mpdf->SetImportUse();
//$mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf([
	'format'			=> 'A4',
	'mode'			  => 'utf-8',
	'default_font_size' => '14',
	'default_font' 	  => 'thsarabun',
	]);

$mpdf->SetDocTemplate('../pdf/templateshipment.pdf', 1);
$mpdf->AddPage('L');

$txt1 = $row_search_shipment['product_dateout']; //วันที่ขึ้นสินค้า
$txt2 = $row_search_shipment['product_payment_id']; //เลขที่เอกสาร
$txt3 = $row_search_shipment['ref_product_payment_id']; //หมายเลขตั๋วสินค้า
$txt4 = $row_search_shipment['type_product']; // รายการสินค้า
$txt5 = $row_search_shipment['product_amount']; // จำนวน (ตัน)
$txt6 = $row_search_customer['name']; // ชื่อผู้ซื้อ
$txt7 = $row_search_customer['telephone']; // เบอร์โทรศัพท์ผู้ซื้อ
$txt8 = $row_search_customer['faxnumber']; // เบอร์โทรสารผู้ซื้อ
$txt9 = $row_search_shipment['customer_destination']; // ที่อยู่เพื่อการจัดส่งสินค้า
//$txt10 = 'สถานที่จัดส่ง';

$mpdf->WriteFixedPosHTML($txt1, 15, 42, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt1, 155, 42, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt2, 15, 48, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt2, 155, 48, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt3, 15, 55, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt3, 155, 55, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt10, 15, 62, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt10, 155, 62, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt4, 103, 62, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt4, 245, 62, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt5, 103, 67, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt5, 245, 67, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt6, 32, 90, 20, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt6, 172, 90, 20, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt7, 55, 90, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt7, 195, 90, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt8, 115, 90, 10, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt8, 255, 90, 10, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt9, 135, 90, 10, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt9, 275, 90, 10, 90, 'auto');

$mpdf->Output();
?>

</body>
</html>
<?php
mysql_free_result($search_shipment);

mysql_free_result($search_customer);
?>
