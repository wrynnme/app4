<?php require_once('../../../../Connections/ml.php'); ?>
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
$query_listshipment = "SELECT * FROM shipment";
$listshipment = mysql_query($query_listshipment, $ml) or die(mysql_error());
$row_listshipment = mysql_fetch_assoc($listshipment);
$totalRows_listshipment = mysql_num_rows($listshipment);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>หน้าจัดการข้อมูลลูกค้า</title>
<!--<link rel= "stylesheet" href="../../../../bootstrap/css/bootstrap.css"> -->
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<br>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><table width="1300" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="10" align="center" bgcolor="#FF9900" class="h3">ข้อมูลการรับ - จ่าย เอกสารใบจ่ายสินค้า</td>
        <td width="132" colspan="2" align="center" valign="middle" bgcolor="#FFCC66" class="small"><p><a href="../../index.php">กลับไปหน้าเมนู</a></p></td>
      </tr>
      <tr>
        <td width="50" align="center" bgcolor="#66FFFF" class="small">ลำดับที่</td>
        <td width="100" align="center" bgcolor="#66FFFF" class="small">วันที่</td>
        <td width="100" align="center" bgcolor="#66FFFF" class="small">เลขที่ใบจ่ายสินค้า</td>
        <td width="150" align="center" bgcolor="#66FFFF" class="small">ชนิดสินค้า</td>
        <td width="200" align="center" bgcolor="#66FFFF" class="small">ผู้ซื้อ</td>
        <td width="250" align="center" bgcolor="#66FFFF" class="small">ปลายทางส่งสินค้า</td>
        <td width="100" align="center" bgcolor="#66FFFF" class="small">วันรับสินค้า<br>
          ต้นทาง</td>
        <td width="50" align="center" bgcolor="#66FFFF" class="small">จำนวน<br>
          (ตัน)</td>
        <td width="100" align="center" bgcolor="#66FFFF" class="small">เลขทะเบียน<br>
          รถที่ไปรับ</td>
        <td width="100" align="center" bgcolor="#66FFFF" class="small">สถานะ</td>
        <td colspan="2" align="center" bgcolor="#FFCC66"><span class="small"><a href="addshipment.php">เพิ่มข้อมูลใหม่</a></span></td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>
        
        <?php do { ?>
		<?php $count_numner = $count_numner+1 ;?>
        <tr>
            <td width="50" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $count_numner; ?></span></td>
            <td width="100" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $row_listshipment['transaction_date']; ?></span></td>
            <td width="100" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_payment_id']; ?></td>
            <td width="150" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['type_product']; ?></td>
            <td width="200" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_name']; ?></td>
            <td width="250" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_destination']; ?></td>
            <td width="100" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_dateout']; ?></td>
            <td width="50" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_amount']; ?></td>
            <td width="100" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['car_id']; ?></td>
            <td width="100" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['status']; ?></td>
            <td width="50" align="center" bgcolor="#FFFFFF"><span class="small"><a href="detelcustomer.php?id=<?php echo $row_listshipment['id']; ?>">แสดง</a></span></td>
            <td width="50" align="center" bgcolor="#FFFFFF"><span class="small"><a href="deleteshipment.php?id=<?php echo $row_listshipment['id']; ?>" onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')">ลบข้อมูล</a></span></td>
            
        </tr>
		<?php } while ($row_listshipment = mysql_fetch_assoc($listshipment)); ?>
    </table>
    <a href="../../index.php"></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($listshipment);

//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
?>
