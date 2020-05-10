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
  	switch ($_POST['status'])
					{
						case "0" : $updateSQL = sprintf("UPDATE shipment SET status=%s, picturestatus1='', 	picturestatus2='', picturestatus3='', picturestatus4='', picturestatus5='' WHERE id=%s",
				                       GetSQLValueString($_POST['status'], "int"),
                				       GetSQLValueString($_POST['id'], "int"));
										break;
						case "1" : $updateSQL = sprintf("UPDATE shipment SET status=%s, picturestatus2='', picturestatus3='', picturestatus4='', picturestatus5='' WHERE id=%s",
				                       GetSQLValueString($_POST['status'], "int"),
                				       GetSQLValueString($_POST['id'], "int"));
										break;
						case "2" : $updateSQL = sprintf("UPDATE shipment SET status=%s, picturestatus4='', picturestatus5='' WHERE id=%s",
				                       GetSQLValueString($_POST['status'], "int"),
                				       GetSQLValueString($_POST['id'], "int"));
										break;
						case "3" :$updateSQL = sprintf("UPDATE shipment SET status=%s, picturestatus5='' WHERE id=%s",
				                       GetSQLValueString($_POST['status'], "int"),
                				       GetSQLValueString($_POST['id'], "int"));
										break;
						case "4" : $updateSQL = sprintf("UPDATE shipment SET status=%s  WHERE id=%s",
				                       GetSQLValueString($_POST['status'], "int"),
                				       GetSQLValueString($_POST['id'], "int"));
										break;
						case "9" : $updateSQL = sprintf("UPDATE shipment SET status=%s, picturestatus1='', 	picturestatus2='', picturestatus3='', picturestatus4='', picturestatus5='' WHERE id=%s",
				                       GetSQLValueString($_POST['status'], "int"),
                				       GetSQLValueString($_POST['id'], "int"));															
					}
/*  
  $updateSQL = sprintf("UPDATE shipment SET status=%s WHERE id=%s",
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['id'], "int"));
*/
  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());

  $updateGoTo = "detelcustomer.php?".$_GET['id'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_Recordset1 = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $ml) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>
<body>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="3" align="center" bgcolor="#66CCFF">แก้ไขสถานะเอกสาร</td>
    </tr>
    <tr>
      <td width="40%" bgcolor="#FFCC66">วันที่ทำรายการเอกสาร <?php echo $row_Recordset1['transaction_date']; ?></td>
      <td width="40%" bgcolor="#FFCC99">ลำดับสถานะการทำงานปัจจุบัน 
	  		<?php 
				switch ($row_Recordset1['status'])
					{
						case "0" : echo "รอพิมพ์ใบส่งสินค้า";break;
						case "1" : echo "รอพิมพ์ใบตั้งเบิก";break;
						case "2" : echo "รอพิมพ์ใบเสร็จรับเงิน";break;
						case "3" : echo "รอพิมพ์สลิปค่าจ้าง";break;
						case "4" : echo "สิ้นสุดกระบวนการ";break;
						case "9" : echo "ยกเลิกเอกสาร";break;						
					}

			?>
      </td>
      <td width="20%" bgcolor="#FFCC66"><input name="id" type="hidden" id="id" value="<?php echo $_GET['id'];?>"></td>
    </tr>
    <tr>
      <td width="40%" bgcolor="#FFCC66">ชื่อผู้ซื้อ <?php echo $row_Recordset1['customer_name']; ?></td>
      <td width="40%" bgcolor="#FFCC99">เปลี่ยนสถานะการทำงานเป็น&nbsp;
        <select name="status" class="small" id="status">
         <!-- <option value="#" <?php// if (!(strcmp("#", $row_Recordset1['status']))) {echo "selected=\"selected\"";} ?>>เลือกสถานะเอกสาร</option> -->
          <option value="0" <?php if (!(strcmp("0", $row_Recordset1['status']))) {echo "selected=\"selected\"";} ?>>รอพิมพ์ใบส่งสินค้า</option>
          <option value="1" <?php if (!(strcmp("1", $row_Recordset1['status']))) {echo "selected=\"selected\"";} ?>>รอพิมพ์ใบตั้งเบิก</option>
          <option value="2" <?php if (!(strcmp("2", $row_Recordset1['status']))) {echo "selected=\"selected\"";} ?>>รอพิมพ์ใบเสร็จรับเงิน</option>
          <option value="3" <?php if (!(strcmp("3", $row_Recordset1['status']))) {echo "selected=\"selected\"";} ?>>รอพิมพ์สลิปค่าจ้าง</option>
          <option value="4" <?php if (!(strcmp("4", $row_Recordset1['status']))) {echo "selected=\"selected\"";} ?>>สิ้นสุดกระบวนการ</option>
          <option value="9" <?php if (!(strcmp("9", $row_Recordset1['status']))) {echo "selected=\"selected\"";} ?>>ยกเลิกเอกสาร</option>
      </select></td>
      <td width="20%" bgcolor="#FFCC66">&nbsp;</td>
    </tr>
    <tr>
      <td width="40%" bgcolor="#FFCC66">รายการสินค้า <?php echo $row_Recordset1['type_product']; ?></td>
      <td width="40%" bgcolor="#FFCC99"><input type="submit" name="button" id="button" value="เปลี่ยนสถานะ" >
      </td>
      <td width="20%" bgcolor="#FFCC66">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
