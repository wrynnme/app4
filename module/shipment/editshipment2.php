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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE shipment SET car_id=%s, car_type=%s WHERE id=%s",                                              
                       GetSQLValueString($_POST['car_id'], "text"),
                       GetSQLValueString($_POST['car_type'], "text"),
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

$colname_show_shipment = "-1";
if (isset($_GET['id'])) {
  $colname_show_shipment = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_show_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_show_shipment, "int"));
$show_shipment = mysql_query($query_show_shipment, $ml) or die(mysql_error());
$row_show_shipment = mysql_fetch_assoc($show_shipment);
$totalRows_show_shipment = mysql_num_rows($show_shipment);

/*
$colname_search_product = "-1";
if (isset($row_show_shipment['product_id'])) {
  $colname_search_product = $row_show_shipment['product_id'];
//  $colname_search_product = $_GET['product_id'];
}
mysql_select_db($database_ml, $ml);
$query_search_product = sprintf("SELECT * FROM product WHERE product_id = %s", GetSQLValueString($colname_search_product, "int"));
$search_product = mysql_query($query_search_product, $ml) or die(mysql_error());
$row_search_product = mysql_fetch_assoc($search_product);
$totalRows_search_product = mysql_num_rows($search_product);
*/

$colname_search_drivermember = "-1";
//if (isset($_GET['driver_id'])) {
//  $colname_search_drivermember = $_GET['driver_id'];
if (isset($row_show_shipment['drivermember_id'])) {
  $colname_search_drivermember = $row_show_shipment['drivermember_id'];
}
mysql_select_db($database_ml, $ml);

$query_search_drivermember = sprintf("SELECT * FROM drivermember WHERE driver_id = %s", GetSQLValueString($colname_search_drivermember, "int"));
$search_drivermember = mysql_query($query_search_drivermember, $ml) or die(mysql_error());
$row_search_drivermember = mysql_fetch_assoc($search_drivermember);
$totalRows_search_drivermember = mysql_num_rows($search_drivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<!--<p>รหัสลำดับที่ใบส่งสินค้า <?php //echo $_GET["id"]; ?></p>
<p>ชื่อไฟล์ <?php //echo $row_show_shipment['pictureorder']; ?></p>
<p>รหัสสินค้า <?php //echo $row_show_shipment['product_id']; ?><br>
  ชื่อสินค้า <?php //echo $row_search_product['product_name']; ?><br>
  แหล่งรับสินค้า <?php //echo $row_search_product['product_source_code']; ?></p>
<p>รหัสคนขับรถ <?php //echo $row_show_shipment['drivermember_id']; ?><br>
  ชื่อคนขับรถ <?php //echo $row_search_drivermember['driver_first_name']; ?>&nbsp;  <?php //echo $row_search_drivermember['driver_last_name']; ?><br>
  หมายเลขทะเบียนรถ <?php //echo $row_search_drivermember['driver_car_id']; ?><br>
ประเภทรถ <?php //echo $row_search_drivermember['driver_car_type']; ?></p>
<p>&nbsp;</p> -->

<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<br />  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>
		<input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"> 
        <input type="hidden" name="car_id" value="<?php echo $row_search_drivermember['driver_car_id']; ?>">
        <input type="hidden" name="car_type" value="<?php echo $row_search_drivermember['driver_car_type']; ?>">
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
mysql_free_result($show_shipment);

mysql_free_result($search_product);

mysql_free_result($search_drivermember);
?>
