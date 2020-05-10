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

$colname_search_bill_oil = "-1";
if (isset($_POST['product_payment_id'])) {
  $colname_search_bill_oil = $_POST['product_payment_id'];
}
mysql_select_db($database_ml, $ml);
$query_search_bill_oil = sprintf("SELECT * FROM receipt_member WHERE product_payment_id LIKE %s", GetSQLValueString($colname_search_bill_oil, "text"));
$search_bill_oil = mysql_query($query_search_bill_oil, $ml) or die(mysql_error());
$row_search_bill_oil = mysql_fetch_assoc($search_bill_oil);
$totalRows_search_bill_oil = mysql_num_rows($search_bill_oil);
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
          <td height="45" align="center" bgcolor="#FF9900">ยกเลิกเอกสารใบบันทึกเบิกค่าน้ำมันคนขับรถ</td>
          </tr>
        <tr>
          <td height="45" align="center" bgcolor="#FFFFCC"><label for="product_payment_id">กรุณาใส่เลขที่ เอกสารใบส่งสินค้า  </label>
            <input type="text" name="product_payment_id" id="product_payment_id"></td>
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
          <td height="35" colspan="7" align="center" bgcolor="#FFCC00">
          	<p> ข้อมูลเอกสารใบบันทึกเบิกค่าน้ำมันคนขับรถที่ต้องการยกเลิก <?php  echo "[หมายเลขใบส่งสินค้า: ".$row_search_bill_oil['product_payment_id']."]";?></p>
          	<p> ชื่อคนขับรถ : 
            <?php 
				if ($row_search_bill_oil['product_payment_id'] <> ""){
					//เรียกฐานข้อมูลลูกค้าเพื่อใช้ในการชื่อลูกค้า
					mysql_select_db($database_ml, $ml);
					$query_list_member = "SELECT * FROM drivermember WHERE driver_id = ".$row_search_bill_oil['member_id'];
					//echo "!!!!!   ".$query_list_member;
					//echo $query_list_customer;
					$list_member = mysql_query($query_list_member, $ml) or die(mysql_error());
					$row_list_member = mysql_fetch_assoc($list_member);
					$totalRows_list_member = mysql_num_rows($list_member);
//					echo $totalRows_list_member;
					//สิ้นสุดเรียกฐานข้อมูลลูกค้าเพื่อใช้ในการชื่อลูกค้า		  		  
				}
				  echo $row_list_member['driver_first_name']."     ".$row_list_member['driver_last_name'];
			?>            
          </td>
          </tr>
        <tr>
          <td width="5%" height="25" align="center" valign="middle" bgcolor="#FFCC99">ลำดับที่</td>
          <td width="19%" height="25" align="center" valign="middle" bgcolor="#FFCC99">หมายเลขใบส่งสินค้า</td>
          <td width="15%" align="center" valign="middle" bgcolor="#FFCC99">วันที่เบิกเงินค่าน้ำมัน</td>
          <td width="13%" height="25" align="center" valign="middle" bgcolor="#FFCC99">หมายเลขใบเสร็จน้ำมัน</td>
          <td width="21%" align="center" valign="middle" bgcolor="#FFCC99">รายละเอียด</td>
          <td width="19%" align="center" valign="middle" bgcolor="#FFCC99">จำนวนเงิน</td>
          <td width="8%" height="25" align="center" valign="middle" bgcolor="#FFCC99"><a href="module/shipment/reset_bill_oil2.php?product_payment_id=<?php echo $colname_search_bill_oil?>" class="btn-secondary" target="new">ยกเลิกใบบันทึกน้ำมัน</a></td>
        </tr>
        <?php  $count = 1; ?>
         <?php do { ?>
        <tr>         
            <td height="25" align="center" valign="middle" bgcolor="#CCFFFF"><?php echo $count; ?></td>
            <td height="25" align="left" valign="middle" bgcolor="#CCFFFF">
		      <?php echo $row_search_bill_oil['product_payment_id']; ?></td>
            <td height="25" align="center" valign="middle" bgcolor="#CCFFFF"><?php if ($row_search_bill_oil['payout_oil_date'] <> "") {echo $row_search_bill_oil['payout_oil_date'];} else { echo " - " ;} ?></td>          
            <td height="25" align="center" valign="middle" bgcolor="#CCFFFF"><?php if ($row_search_bill_oil['payout_oil_bill_no'] <> "") {echo $row_search_bill_oil['payout_oil_bill_no'];} else { echo " - " ;}?></td>
            <td height="25" align="center" valign="middle" bgcolor="#CCFFFF"><?php if ($row_search_bill_oil['payout_oil_bill_comment'] <> "") {echo $row_search_bill_oil['payout_oil_bill_comment'];}  else { echo "ไม่เบิกค่าน้ำมัน" ;} ?></td>
            <td height="25" align="right" valign="middle" bgcolor="#CCFFFF"><?php  if ($row_search_bill_oil['payout_oil_bill_total'] <> "") {echo (number_format($row_search_bill_oil['payout_oil_bill_total'],2));} else { echo " - " ;} ?></td>
            <td height="25" align="center" valign="middle" bgcolor="#CCFFFF">
				<?php 
					if ($row_search_bill_oil['receipt_member_no'] <> "")
					{
						echo "<font color=#FF0000>พิมพ์ใบเสร็จค่าจ้างแล้ว : ".$row_search_bill_oil['receipt_member_no']."</font>";
					}
					else
					{
					
					}
				?>
        	</td>            
        </tr>  
        <?php 
			$count = $count + 1;
			$totalamount =$totalamount +  $row_search_reset_bill['amount'];
			$totalamount2 = $totalamount2 + $row_search_reset_bill['amount2']; 
			$totalall = $totalamount + $totalamount2;
		?>     
		<?php } while ($row_search_bill_oil = mysql_fetch_assoc($search_bill_oil)); ?>
         <tr>
          <td height="12" colspan="3" align="right" valign="middle">รวมเป็นเงิน &nbsp; </td>
          <td height="12" colspan="3" align="right" valign="middle">
          <?php  //echo (number_format($totalall,2));?>
          </td>
          <td height="12" align="center" valign="middle">บาท</td>
          </tr>
         <tr>
           <td height="13" colspan="7" align="center" valign="middle"><a href="module/shipment/reset_bill_oil2.php?product_payment_id=<?php echo $colname_search_bill_oil?>" class="btn-secondary" target="new">ยกเลิกใบบันทึกน้ำมัน</a></td>
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
mysql_free_result($search_bill_oil);

mysql_free_result($search_reset_bill);
?>
