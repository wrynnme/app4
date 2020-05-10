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

mysql_select_db($database_ml, $ml);
$query_list_customer = "SELECT * FROM customer";
$list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
$row_list_customer = mysql_fetch_assoc($list_customer);
$totalRows_list_customer = mysql_num_rows($list_customer);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<!--Script ค้นหาข้อมูลแสดงใน Listbox  -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="../module/shipment/dist/css/bootstrap-select.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="../module/shipment/dist/js/bootstrap-select.js"></script>
<!--END Script ค้นหาข้อมูลแสดงใน Listbox  -->

<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<form name="form1" method="get" action="report11.php">
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="30" colspan="3" align="center" bgcolor="#FFFF99">รายงานข้อมูลใบสั่งสินค้า</td>
    </tr>
    <tr>
      <td height="30" colspan="2" bgcolor="#66FFCC">      แยกตามสถานะใบสั่งสินค้า</td>
      <td width="62%" height="30" bgcolor="#66FFCC">
      	<select name="status" class="small" id="status">
            <option value="">เลือกสถานะเอกสาร</option>
            <option value="999" selected="selected">ทั้งหมด</option>
            <option value="0">รอพิมพ์ใบส่งสินค้า</option>
            <option value="1">รอพิมพ์ใบตั้งเบิก</option>
            <option value="2">รอพิมพ์ใบเสร็จรับเงิน</option>
            <option value="3">รอพิมพ์สลิปค่าจ้าง</option>
            <option value="4">สิ้นสุดกระบวนการ</option>
            <option value="9">เอกสารถูกยกเลิก</option>
            <!--<option value="index.php?pagename=0&status=99">รายการมาใหม่ล่าสุด</option> -->
      	</select>
      </td>
    </tr>
    <tr>
      <td height="30" colspan="2" bgcolor="#FFCCCC">      รายชื่อลูกค้า</td>
      <td height="30" bgcolor="#FFCCCC">
 <span class="small">               
          <select name="customer_id" id="select" class="selectpicker" data-live-search="true">
            <?php
do {  
?>
            <option value="<?php echo $row_list_customer['id']?>"><?php echo $row_list_customer['name']?></option>
            <?php
} while ($row_list_customer = mysql_fetch_assoc($list_customer));
  $rows = mysql_num_rows($list_customer);
  if($rows > 0) {
      mysql_data_seek($list_customer, 0);
	  $row_list_customer = mysql_fetch_assoc($list_customer);
  }
?>
          </select>
      </td>
    </tr>
    <tr>
      <td width="21%" height="30" bgcolor="#99CCFF">      ระยะเวลา</td>
      <td width="17%" height="30" align="right" bgcolor="#99CCFF">จากวันที่ </td>
      <td height="30" bgcolor="#99CCFF">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" bgcolor="#99CCFF">&nbsp;</td>
      <td height="30" align="right" bgcolor="#99CCFF">ถึงวันที่ </td>
      <td height="30" bgcolor="#99CCFF">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="30" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="30" align="center" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="แสดงข้อมูล"></td>
    </tr>
  </table>
</form>



<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($list_customer);
?>