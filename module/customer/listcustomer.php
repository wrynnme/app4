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
$query_list_customer = "SELECT * FROM customer";
$list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
$row_list_customer = mysql_fetch_assoc($list_customer);
$totalRows_list_customer = mysql_num_rows($list_customer);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>หน้าจัดการข้อมูลลูกค้า</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
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
    <td align="center" bgcolor="#FFFFCC"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5" align="center" bgcolor="#FF9900" class="h3">ข้อมูลลูกค้า</td>
        <td width="132" colspan="3" align="center" valign="middle" bgcolor="#FFCC66" class="small"><p><a href="index.php?pagename=listcustomer">Reload</a></p></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#66FFFF"><span class="small">ลำดับที่</span></td>
        <td width="35%" align="center" bgcolor="#66FFFF"><span class="small">ชื่อลูกค้า</span></td>
        <td width="15%" align="center" bgcolor="#66FFFF"><span class="small">โทรศัพท์</span></td>
        <td width="15%" align="center" bgcolor="#66FFFF"><span class="small">โทรสาร</span></td>
        <td width="15%" align="center" bgcolor="#66FFFF"><span class="small">เลขประจำตัวผู้เสียภาษี</span></td>
        <td colspan="3" align="center" bgcolor="#FFCC66"><span class="small"><a href="module/customer/addcustomer.php" target="new">เพิ่มข้อมูลใหม่</a></span></td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>      
        <?php do { ?>
        <?php $count_numner = $count_numner+1 ;?>
        <tr>
          <td width="5%" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $count_numner; ?></span></td>
          <td width="35%" align="left" bgcolor="#FFFFFF"><span class="small" onClick="MM_openBrWindow('module/customer/detelcustomer.php?id=<?php echo $row_list_customer['id']; ?>','','width=800,height=400')"><?php echo $row_list_customer['name']; ?></span></td>
          <td width="15%" align="left" bgcolor="#FFFFFF"><span class="small"><?php echo $row_list_customer['telephone']; ?></span></td>
          <td width="15%" align="left" bgcolor="#FFFFFF"><span class="small"><?php echo $row_list_customer['faxnumber']; ?></span></td>
          <td width="15%" align="left" bgcolor="#FFFFFF"><span class="small"><?php echo $row_list_customer['tax_customer_id']; ?></span></td>
          <td width="5%" align="center" bgcolor="#FFFFFF" class="small"><a href="module/customer/detelcustomer.php?id=<?php echo $row_list_customer['id']; ?>" target="new"><ion-icon name="paper"></ion-icon></a></td>
          <td width="5%" align="center" bgcolor="#FFFFFF"><a href="module/customer/editcustomer.php?id=<?php echo $row_list_customer['id']; ?>" target="new" class="small"><ion-icon name="settings"></ion-icon></a></td>
          <td width="5%" align="center" bgcolor="#FFFFFF"><span class="small"><a href="module/customer/deletecustomer.php?id=<?php echo $row_list_customer['id']; ?>" onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"><ion-icon name="remove-circle-outline"></ion-icon></a></span></td>
 	   </tr>       
	   <?php } while ($row_list_customer = mysql_fetch_assoc($list_customer)); ?>
  </table>
    <a href="../../index.php"></a></td>
  </tr>
</table>
</body>
</html>
<?php
//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
mysql_free_result($list_customer);
?>
