<?php require_once("../../Connections/ml.php"); ?>
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


$colname_delete_shipment = "-1";
if (isset($_GET['id'])) {
  $colname_delete_shipment = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_delete_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_delete_shipment, "int"));
$delete_shipment = mysql_query($query_delete_shipment, $ml) or die(mysql_error());
$row_delete_shipment = mysql_fetch_assoc($delete_shipment);
$totalRows_delete_shipment = mysql_num_rows($delete_shipment);


if ((isset($_GET['id'])) && ($_GET['id'] != "")) {

if ($row_delete_shipment['status']==2)
{
	$new_status = 3;
	$picturestatus4 = $_GET['product_payment_id']."-4.pdf";
}
else
{
	$new_status = $row_delete_shipment['status'];
}
	
  $deleteSQL = sprintf("UPDATE shipment SET picturestatus4=%s, status=%s WHERE id=%s",
                       GetSQLValueString($picturestatus4, "text"),
					   GetSQLValueString($new_status, "int"),
					   GetSQLValueString($_GET['id'], "int"));
					   

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($deleteSQL, $ml) or die(mysql_error());

  //$deleteGoTo = "../../index.php?pagename=listshipment";
  $deleteGoTo = "../pdf/printreceipt.php?id=".$_GET['id'];
  
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($delete_shipment);
?>
