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

//----- ค้นหาข้อมูลในตารางใบสั่งจ่าย ที่มีสถานะ 99 (เปิดบิลใหม่) -----------------------------
/*
		สถานะ 99 = เปิดบิลใหม่
		สถานะ 0 = รอพิมพ์ใบส่งสินค้า
		สถานะ 1 = พิมพ์ใบส่งสินค้าแล้ว
		สถานะ 2 = สินค้าส่งเรียบร้อยแล้วรอการเรียกเก็บเงิน
		สถานะ 3 = ออกใบตั้งเบิกแล้ว
		สถานะ 4 = ออกใบเสร็จเรียกเก็บเงินแล้ว
		สถานะ 5 = รับเงินจากลูกค้าแล้ว
		สถานะ 6 = ออกใบจ่ายค่าจ้างแก่คนขับรถส่งของแล้ว
*/
mysql_select_db($database_ml, $ml);
$query_update_shipment = "SELECT * FROM shipment WHERE status = 99";
$update_shipment = mysql_query($query_update_shipment, $ml) or die(mysql_error());
$row_update_shipment = mysql_fetch_assoc($update_shipment);
$totalRows_update_shipment = mysql_num_rows($update_shipment);

$id = $row_update_shipment['id'];
$product_id = $row_update_shipment['product_id'];
$drivermember_id = $row_update_shipment['drivermember_id'];
$customer_id = $row_update_shipment['customer_id'];
//-----------------------------------------------------------------------------------

//----- ค้นหาข้อมูลในตารางคนขับรถเพื่อ Update ในตารางใบสั่งจ่าย-----------------------------
mysql_select_db($database_ml, $ml);
$query_search_drivermember = "SELECT * FROM drivermember WHERE driver_id =". $drivermember_id;
$search_drivermember = mysql_query($query_search_drivermember, $ml) or die(mysql_error());
$row_search_drivermember = mysql_fetch_assoc($search_drivermember);
$totalRows_search_drivermember = mysql_num_rows($search_drivermember);

$car_id = $row_search_drivermember['driver_car_id'];
//$car_type = $row_search_drivermember['$driver_car_type'];
//-------------------------------------------------------------------------------------

//----- ค้นหาข้อมูลในตารางสินค้าเพื่อ Update ในตารางใบสั่งจ่าย-----------------------------
mysql_select_db($database_ml, $ml);
$query_search_product = "SELECT * FROM product WHERE product_id =". $product_id;
$search_product = mysql_query($query_search_product, $ml) or die(mysql_error());
$row_search_product = mysql_fetch_assoc($search_product);
$totalRows_search_product = mysql_num_rows($search_product);

$product_name = $row_search_product['product_name'];
$product_source_code = $row_search_product['product_source_code'];
//-------------------------------------------------------------------------------

//----- ค้นหาข้อมูลลูกค้าเพื่อ Update ในตารางใบสั่งจ่าย-----------------------------
mysql_select_db($database_ml, $ml);
$query_search_customer = "SELECT * FROM customer WHERE id =". $customer_id;
$search_customer = mysql_query($query_search_customer, $ml) or die(mysql_error());
$row_search_customer = mysql_fetch_assoc($search_customer);
$totalRows_search_customer = mysql_num_rows($search_customer);

$customer_name = $row_search_customer['name'];
//-------------------------------------------------------------------------------

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE shipment SET type_product=%s, productsource=%s, customer_name=%s, car_id=%s, car_type=%s, status=%s WHERE id=%s",
                       GetSQLValueString($_POST['row_search_product'], "text"),
                       GetSQLValueString($_POST['product_source_code'], "text"),
                       GetSQLValueString($_POST['customer_name'], "text"),
                       GetSQLValueString($_POST['car_id'], "text"),
                       GetSQLValueString($_POST['car_type'], "text"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());

  $updateGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<style type="text/css">
body {
	background-color: #FFF;
}
</style>
</head>

<body>
<!--<p>พบข้อมูล</br>
  1. <?php//  echo $drivermember_id;?> </br>
  รายละเอียด ทะเบียนรถ : <?php// echo $row_search_drivermember['driver_car_id']; ?><br>
  รายละเอียด ประเภทรถ : <?php// echo $row_search_drivermember['driver_car_type']; ?><br>
  2. <?php//  echo $product_id;?> </br>
  รายละเอียด ชื่อสินค้า :<?php// echo $row_search_product['product_name']; ?></br>
  รายละเอียด สถานที่รับสินค้าต้นทาง :<?php// echo $row_search_product['product_source_code']; ?></br>
  3. <?php// $id; ?></br>
  ร่ายบละเอียด : <?php// echo $row_search_customer['name']?>
</p> -->
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<br />  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>
		<input type="hidden" name="id" value="<?php echo $id; ?>">
      	<input type="hidden" name="status"  value="0">        
        <input type="hidden" name="car_id" value="<?php echo $row_search_drivermember['driver_car_id']; ?>">
        <input type="hidden" name="car_type" value="<?php echo $row_search_drivermember['driver_car_type']; ?>">
        <input type="hidden" name="row_search_product" value="<?php echo $row_search_product['product_name']; ?>">
        <input type="hidden" name="product_source_code" value="<?php echo $row_search_product['product_source_code']; ?>">
        <input type="hidden" name="customer_name" value="<?php echo $row_search_customer['name']?>">
      <input type="hidden" name="MM_update" value="form1"></td>
    </tr>
    <tr>
      <td align="center" class="bg-success"><input name="button" type="submit" class="btn-block" id="button" value="ปรับปรุงข้อมูลเรียบร้อย...กดปุ่มนี้เพื่อกลับไปหน้าแสดงข้อมูล"></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($update_shipment);

mysql_free_result($search_drivermember);
?>
