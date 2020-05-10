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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
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

$mpdf->SetDocTemplate('templateshipment.pdf', 1);
$mpdf->AddPage('L');

if ($row_search_shipment['customer_name'] <> ""){$txt1 = $row_search_shipment['customer_name'];}else {$txt1 = "";}
if ($row_search_shipment['customer_destination'] <> ""){$txt2 = $row_search_shipment['customer_destination'];}else {$txt2 = "";}

if ($row_search_shipment['product_payment_id'] <> ""){$txt3 = $row_search_shipment['product_payment_id'];}else {$txt3 = "";}
if ($row_search_shipment['product_dateout'] <> ""){$txt4 = $row_search_shipment['product_dateout'];}else {$txt4 = "";}

if ($row_search_shipment['ref_product_payment_id'] <> ""){$txt5 = $row_search_shipment['ref_product_payment_id'];}else {$txt5 = "";}
if ($row_search_shipment['type_product'] <> ""){$txt6 = $row_search_shipment['type_product'];}else {$txt6 = "";}
if ($row_search_shipment['product_amount'] <> ""){$txt7 = $row_search_shipment['product_amount'];}else {$txt7 = "";}

//$txt2 = 'ที่อยู่ 555 ถนนพิชัยรณรงค์สงคราม ต.ปากเพรียว อ.เมือง จ.สระบุรี';
//$txt3 = 'โทรศัพท์ 0XXXXXXXXX โทรสาร 0XXXXXXXXXX';
//$txt4 = 'วันที่ '.$row_search_shipment['product_dateout'];
//$txt5 = 'เลขที่เอกสาร '.$row_search_shipment['product_payment_id'];
//$txt6 = $row_search_shipment['ref_product_payment_id'];
//$txt7 = $row_search_shipment['type_product'];
//$txt8 = '';
//$txt9 = $row_search_shipment['product_amount'];
//$txt10 = $row_search_shipment['customer_destination'];


//$mpdf->WriteFixedPosHTML($txt1, 15, 42, 100, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt1, 155, 42, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML('ชื่อผู้สั่งสินค้า : '.$txt1, 15, 48, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML('ชื่อผู้สั่งสินค้า : '.$txt1, 155, 48, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt3, 15, 55, 100, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt3, 155, 55, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML('สถานที่ส่งสินค้า : '.$txt2, 15, 62, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML('สถานที่ส่งสินค้า : '.$txt2, 155, 62, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML('วันที่ขึ้นสินค้า : '.$txt4, 103, 62, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML('วันที่ขึ้นสินค้า : '.$txt4, 245, 62, 100, 90, 'auto');

$mpdf->WriteFixedPosHTML('เลขที่เอกสาร : '.$txt3, 103, 67, 50, 90, 'auto');
$mpdf->WriteFixedPosHTML('เลขที่เอกสาร : '.$txt3, 245, 67, 50, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt5, 32, 90, 20, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt5, 172, 90, 20, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt6, 55, 90, 100, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt6, 195, 90, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt8, 115, 90, 10, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt8, 255, 90, 10, 90, 'auto');

$mpdf->WriteFixedPosHTML($txt7, 135, 90, 10, 90, 'auto');
$mpdf->WriteFixedPosHTML($txt7, 275, 90, 10, 90, 'auto');

$mpdf->Output();
?>


</body>
</html>
<?php
mysql_free_result($search_shipment);
?>
