<?php require_once('Connections/ml.php'); ?>
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
<title>จัดการใบส่งสินค้า</title>
<link rel= "stylesheet" href="bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="11" align="center" bgcolor="#FF9900" class="h3">จัดการเอกสารใบจ่ายสินค้า</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#66FFFF" class="small">วันที่</td>
        <td align="center" bgcolor="#66FFFF" class="small">เลขที่ใบจ่ายสินค้า</td>
        <td align="center" bgcolor="#66FFFF" class="small">ผู้ซื้อ</td>
        <td align="center" bgcolor="#66FFFF" class="small">ปลายทางส่งสินค้า</td>
        <td align="center" bgcolor="#66FFFF" class="small">วันรับสินค้า<br>
          ต้นทาง</td>
        <td align="center" bgcolor="#66FFFF" class="small">จำนวน<br>
          (ตัน)</td>
        <td align="center" bgcolor="#66FFFF" class="small">สถานะ</td>
        <td colspan="3" align="center" bgcolor="#FFCC66"><a href="module/shipment/addshipment.php" target="thelogis" class="btn btn-primary"><ion-icon name="add-circle-outline"></ion-icon> เพิ่มข้อมูลใหม่</a></td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>
        
        <?php do { ?>
		<?php $count_numner = $count_numner+1 ;?>
        <tr>
            <td align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $row_listshipment['transaction_date']; ?></span></td>
            <td align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_payment_id']; ?></td>            
            <td align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_name']; ?></td>
            <td align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_destination']; ?></td>
            <td align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_dateout']; ?></td>
            <td align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_amount']; ?></td>
            <td align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['status']; ?></td>
            <td align="center" bgcolor="#FFFFFF"><a href="module/shipment/detelcustomer.php?id=<?php echo $row_listshipment['id']; ?>" target="thewiondows"><ion-icon name="paper"></ion-icon></a>            
            </td>
             
            <td align="center" bgcolor="#FFFFFF"><a href="module/shipment/editshipment.php?id=<?php echo $row_listshipment['id']; ?>" target="thewiondows"><ion-icon name="settings"></ion-icon></td>
                        
            <td align="center" bgcolor="#FFFFFF"><a href="module/shipment/deleteshipment.php?id=<?php echo $row_listshipment['id']; ?>" class="btn-outline-danger" onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"><ion-icon name="remove-circle-outline"></ion-icon></a></td>

			
            
            
        </tr>
		<?php } while ($row_listshipment = mysql_fetch_assoc($listshipment)); ?>
    </table>
</body>
</html>
<?php
mysql_free_result($listshipment);

//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
?>
