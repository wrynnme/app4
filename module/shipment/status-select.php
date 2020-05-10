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

// ชุดคำสั่งสร้างชื่อไฟล์ใบส่งของรวม

// ชุดคำสั่งสร้างชื่อไฟล์ใบส่งของรวม

/*
//ชุดคำสั้งวนรอบ Update ข้อมูลใบส่งของในรายละเอียดของใบ Job

if(trim($_POST["id"][$i]) != "")
	{
// ค้นหาข้อมูลเพื่อกำหนดข้อมูลแสดงผลใน 1 รอบ
	$colname_search_shipment = "-1";
	if (isset($_POST["id"][$i])) {
	  $colname_search_shipment = $_POST["id"][$i];  
	}
	
	$colname_search_shipment = "-1";
if (isset()) {
  $colname_search_shipment = ;
}
mysql_select_db($database_ml, $ml);
$query_search_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_search_shipment, "int"));
$search_shipment = mysql_query($query_search_shipment, $ml) or die(mysql_error());
$row_search_shipment = mysql_fetch_assoc($search_shipment);
$totalRows_search_shipment = mysql_num_rows($search_shipment);
// จบค้นหาข้อมูลเพื่อกำหนดข้อมูลแสดงผลใน 1 รอบ

		
//คำสั่ง Update ข้อมูลไฟล์ PDF ใบส่งสินค้าของแต่ละ Job


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

mysql_select_db($database_ml, $ml);
$query_listreceipt = "SELECT * FROM receipt";
$listreceipt = mysql_query($query_listreceipt, $ml) or die(mysql_error());
$row_listreceipt = mysql_fetch_assoc($listreceipt);
$totalRows_listreceipt = mysql_num_rows($listreceipt);

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {

if ($row_delete_shipment['status']==0)
{
	$new_status = 1;
	$picturestatus1 = $_GET['product_payment_id']."-1.pdf";
//	$picturestatus1 = $_GET['product_payment_id']."-1";
}
else
{
	$new_status = $row_delete_shipment['status'];
	$picturestatus1 = $_GET['product_payment_id']."-1.pdf";
//	$picturestatus1 = $_GET['product_payment_id']."-1";
}
	
  $deleteSQL = sprintf("UPDATE shipment SET picturestatus1=%s , status=%s WHERE id=%s",
                       GetSQLValueString($picturestatus1, "text"),
					   GetSQLValueString($new_status, "int"),
					   GetSQLValueString($_GET['id'], "int"));
					   

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($deleteSQL, $ml) or die(mysql_error());

  //$deleteGoTo = "../../index.php?pagename=listshipment";
  $deleteGoTo = "../pdf/printshipment1.php?id=".$_GET['id'];
  
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
*/
	$picturestatus1 = "THE".date(dmYHm)."-1";
	$new_status = 1;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>
    <input name="receipt_id" type="hidden" id="receipt_id" value="9999">
  </p>
  <p>
    <input type="submit" name="button" id="button" value="สร้างใบเสร็จใหม่">
  </p>
  
  <?php
  //ชุดคำสั้งวนรอบ Update ข้อมูลใบส่งของในรายละเอียดของใบ Job
for($i=0;$i<count($_POST["id"]);$i++)

{		
		if(trim($_POST["id"][$i]) != "")
		{
		// ค้นหาข้อมูลเพื่อกำหนดข้อมูลแสดงผลใน 1 รอบ
			if (isset($_POST["id"][$i])) {
				echo "เลขที่ใบ Job ที่ ".$i." :".$_POST["id"][$i]."<br>";  
				
				$insertSQL = sprintf("INSERT INTO receipt (billing_id,shipment_id) VALUES (%s,%s)",
				GetSQLValueString($picturestatus1, "text"),				
				GetSQLValueString($_POST["id"][$i], "text"));
				mysql_select_db($database_ml, $ml);
				$Result1 = mysql_query($insertSQL, $ml) or die(mysql_error());
				
				$file_picturestatus1 = $picturestatus1.".pdf";
				$updateSQL = sprintf("UPDATE shipment SET picturestatus1=%s , status=%s WHERE id=%s",
				GetSQLValueString($file_picturestatus1, "text"),
				GetSQLValueString($new_status, "int"),
				GetSQLValueString($_POST["id"][$i], "int"));
				mysql_select_db($database_ml, $ml);
				$Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());
							
			}
		}
}
  ?>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($delete_shipment);

mysql_free_result($search_shipment);

mysql_free_result($listreceipt);
?>
