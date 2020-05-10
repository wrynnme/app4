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

if ((isset($_GET['driver_id'])) && ($_GET['driver_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM drivermember WHERE driver_id=%s",
                       GetSQLValueString($_GET['driver_id'], "int"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($deleteSQL, $ml) or die(mysql_error());

//  $deleteGoTo = "listdrivermember.php";
  $deleteGoTo = "../../index.php?pagename=listdrivermember";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_delete_drivermember = "-1";
if (isset($_GET['driver_id'])) {
  $colname_delete_drivermember = $_GET['driver_id'];
}
mysql_select_db($database_ml, $ml);
$query_delete_drivermember = sprintf("SELECT * FROM drivermember WHERE driver_id = %s", GetSQLValueString($colname_delete_drivermember, "int"));
$delete_drivermember = mysql_query($query_delete_drivermember, $ml) or die(mysql_error());
$row_delete_drivermember = mysql_fetch_assoc($delete_drivermember);
$totalRows_delete_drivermember = mysql_num_rows($delete_drivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="windows-874">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($delete_drivermember);
?>
