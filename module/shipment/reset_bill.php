<?php //require_once('../../Connections/ml.php'); ?>
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

$colname_search_reset_bill = "-1";
if (isset($_POST['billing_id'])) {
  $colname_search_reset_bill = $_POST['billing_id'];
}
mysql_select_db($database_ml, $ml);
$query_search_reset_bill = sprintf("SELECT * FROM receipt WHERE billing_id = %s", GetSQLValueString($colname_search_reset_bill, "text"));
//echo $query_search_reset_bill;
$search_reset_bill = mysql_query($query_search_reset_bill, $ml) or die(mysql_error());
$row_search_reset_bill = mysql_fetch_assoc($search_reset_bill);
$totalRows_search_reset_bill = mysql_num_rows($search_reset_bill);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="45" align="center" bgcolor="#FFFF00">ยกเลิกเอกสารใบแจ้งหนี้</td>
          </tr>
        <tr>
          <td height="45" align="center" bgcolor="#FFFFCC"><label for="billing_id">กรุณาใส่เลขที่ เอกสารใบแจ้งหนี้  </label>
            <input type="text" name="billing_id" id="billing_id"></td>
          </tr>
        <tr>
          <td height="45" align="center" bgcolor="#FFFFCC"><input type="submit" name="Submit" id="Submit" value="ค้นหาข้อมูล"></td>
          </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="35" colspan="5" align="center" bgcolor="#FFCC00">
          	<p> ข้อมูลเอกสารใบแจ้งหนี้ที่จะยกเลิก <?php  echo "[หมายเลขใบแจ้งหนี้ : ".$row_search_reset_bill['billing_id']."]";?></p>
          	<p> ชื่อผู้ซื้อ : 
            <?php 
				if ($_POST['billing_id'] <> ""){
					//เรียกฐานข้อมูลลูกค้าเพื่อใช้ในการชื่อลูกค้า
					mysql_select_db($database_ml, $ml);
					$query_list_customer = "SELECT * FROM customer WHERE id = ".$row_search_reset_bill['customer_id'];
					//echo $query_list_customer;
					$list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
					$row_list_customer = mysql_fetch_assoc($list_customer);
					$totalRows_list_customer = mysql_num_rows($list_customer);
					//สิ้นสุดเรียกฐานข้อมูลลูกค้าเพื่อใช้ในการชื่อลูกค้า		  		  
				}
				  echo $row_list_customer['name'];
			?>            
          </td>
          </tr>
        <tr>
          <td width="16%" height="25" align="center" valign="middle" bgcolor="#FFCC99">ลำดับที่</td>
          <td width="24%" height="25" align="center" valign="middle" bgcolor="#FFCC99">หมายเลขใบส่งสินค้า</td>
          <td width="25%" align="center" valign="middle" bgcolor="#FFCC99">ชื่อสินค้า</td>
          <td width="23%" height="25" align="center" valign="middle" bgcolor="#FFCC99">จำนวนเงิน (รวมค่าขนส่งเพิ่มแล้ว)</td>
          <td width="12%" height="25" align="center" valign="middle" bgcolor="#FFCC99"><a href="module/shipment/reset_bill2.php?billing_id=<?php echo $colname_search_reset_bill?>" class="btn-secondary" target="new">ยกเลิกใบแจ้งหนี้</a></td>
        </tr>
        <?php  $count = 1; ?>
         <?php do { ?>
        <tr>         
            <td height="25" align="left" valign="middle" bgcolor="#CCFFFF"><?php echo $count; ?></td>
            <td height="25" valign="middle" bgcolor="#CCFFFF">
			   <?php
				   if ($_POST['billing_id'] <> ""){
						//เรียกฐานข้อมูลใบส่งของเพื่อใช้ในการชื่อใบส่งสินค้า
						mysql_select_db($database_ml, $ml);
						$query_list_shipment = "SELECT * FROM shipment WHERE id = ".$row_search_reset_bill['shipment_id'];
						//echo $query_list_shipment;
						$list_shipment = mysql_query($query_list_shipment, $ml) or die(mysql_error());
						$row_list_shipment = mysql_fetch_assoc($list_shipment);
						$totalRows_list_shipment = mysql_num_rows($list_shipment);
						//เรียกฐานข้อมูลใบส่งของเพื่อใช้ในการชื่อใบส่งสินค้า       
				   
					echo $row_list_shipment['product_payment_id'];
				   }
               ?>            
            </td>
            <td height="25" valign="middle" bgcolor="#CCFFFF"><?php echo $row_list_shipment['type_product']; ?></td>
          
            <td height="25" align="right" valign="middle" bgcolor="#CCFFFF"><?php echo (number_format($row_search_reset_bill['amount'] + $row_search_reset_bill['amount2'],2)); ?></td>
            <td height="25" align="center" valign="middle" bgcolor="#CCFFFF">&nbsp;</td>            
        </tr>  
        <?php 
			$count = $count + 1;
			$totalamount =$totalamount +  $row_search_reset_bill['amount'];
			$totalamount2 = $totalamount2 + $row_search_reset_bill['amount2']; 
			$totalall = $totalamount + $totalamount2;
		?>     
		<?php } while ($row_search_reset_bill = mysql_fetch_assoc($search_reset_bill)); ?>
         <tr>
          <td height="12" colspan="3" align="right" valign="middle">รวมเป็นเงิน &nbsp; </td>
          <td height="12" align="right" valign="middle">
          <?php  echo (number_format($totalall,2));?>
          </td>
          <td height="12" align="center" valign="middle">บาท</td>
          </tr>
         <tr>
           <td height="13" colspan="5" align="center" valign="middle"><a href="module/shipment/reset_bill2.php?billing_id=<?php echo $colname_search_reset_bill?>" class="btn-secondary" target="new">ยกเลิกใบแจ้งหนี้</a></td>
         </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($search_reset_bill);
?>
