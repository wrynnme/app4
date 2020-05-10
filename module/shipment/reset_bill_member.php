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

$colname_search_bill_member = "-1";
if (isset($_POST['receipt_member_no'])) {
  $colname_search_bill_member = $_POST['receipt_member_no'];
}
mysql_select_db($database_ml, $ml);
$query_search_bill_member = sprintf("SELECT * FROM receipt_member WHERE receipt_member_no = %s", GetSQLValueString($colname_search_bill_member, "text"));
$search_bill_member = mysql_query($query_search_bill_member, $ml) or die(mysql_error());
$row_search_bill_member = mysql_fetch_assoc($search_bill_member);
$totalRows_search_bill_member = mysql_num_rows($search_bill_member);
 //require_once('../../Connections/ml.php'); ?>
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
          <td height="45" align="center" bgcolor="#FF9900">ยกเลิกเอกสารใบเสร็จค่าจ้างคนขับรถ</td>
          </tr>
        <tr>
          <td height="45" align="center" bgcolor="#FFFFCC"><label for="receipt_member_no">กรุณาใส่เลขที่ เอกสารใบเสร็จค่าจ้างคนขับรถ </label>
            <input type="text" name="receipt_member_no" id="receipt_member_no"></td>
          </tr>
        <tr>
          <td height="45" align="center" bgcolor="#FFFFCC"><input type="submit" name="Submit" id="Submit" value="ค้นหาข้อมูล"> </td>
          </tr>
        <tr>
          <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="35" colspan="7" align="center" bgcolor="#FFCC00">          
          	<p>ข้อมูลเอกสารใบเสร็จรับเงินคนขับรถที่จะยกเลิก <?php echo $row_search_bill_member['receipt_member_no']; ?></p>
            <p>ชื่อคนขับรถ<?php echo $row_search_bill_member['member_id']; ?> <?php echo $row_search_bill_member['payout_bill_type']; ?></p>
          </td>
          </tr>
        <tr>
          <td width="7%" height="25" align="center" valign="middle" bgcolor="#FFCC99">ลำดับที่</td>
          <td width="21%" height="25" align="center" valign="middle" bgcolor="#FFCC99">เลขที่ใบส่งสินค้า</td>
          <td width="19%" align="center" valign="middle" bgcolor="#FFCC99">จำนวนเงินค่าจ้าง [รวมค่าขนส่งเพิ่มแล้ว]</td>
          <td width="15%" height="25" align="center" valign="middle" bgcolor="#FFCC99">เลขที่ใบเสร็จค่าน้ำมัน</td>
          <td width="14%" align="center" valign="middle" bgcolor="#FFCC99">ประเภท</td>
          <td width="12%" align="center" valign="middle" bgcolor="#FFCC99">จำนวนเงิน</td>
          <td width="12%" height="25" align="center" valign="middle" bgcolor="#FFCC99"><a href="module/shipment/reset_bill_member2.php?receipt_member_no=<?php echo  $colname_search_bill_member; ?>"class="btn-secondary" target="new">ยกเลิกใบค่าจ้างคนขับรถ</a></td>
        </tr>
		<?php 
			$count = $count + 1;
		?>
		<?php do { ?>
        <tr>
          
            <td height="25" align="center" valign="middle" bgcolor="#CCFFFF"><?php echo $count; ?></td>
            <td height="25" valign="middle" bgcolor="#CCFFFF"><?php echo $row_search_bill_member['product_payment_id']; ?></td>
            <td height="25" valign="middle" bgcolor="#CCFFFF"><?php echo $row_search_bill_member['rate_priceout_type1']; ?></td>
            <td height="25" valign="middle" bgcolor="#CCFFFF"><?php echo $row_search_bill_member['payout_oil_bill_no']; ?></td>
            <td height="25" valign="middle" bgcolor="#CCFFFF"><?php echo $row_search_bill_member['payout_oil_bill_comment']; ?></td>
            <td height="25" align="right" valign="middle" bgcolor="#CCFFFF"><?php echo $row_search_bill_member['payout_oil_bill_total']; ?></td>
            <td height="25" valign="middle" bgcolor="#CCFFFF"></td>            
        </tr>
        <?php
        	$count = $count + 1;
			$totalamount = $totalamount + $row_search_bill_member['rate_priceout_type1'];
			$totalamount2 =$totalamount2 + $row_search_bill_member['rate_priceout_type3'];			
			$totaloil = $totaloil + $row_search_bill_member['payout_oil_bill_total'];
		?>
		<?php } while ($row_search_bill_member = mysql_fetch_assoc($search_bill_member)); ?>
<tr>
  <td height="12" colspan="5" align="right" valign="middle">รวมเงินที่จ่ายค่าจ้าง</td>
  <td height="12" align="right" valign="middle">
	<?php echo $row_search_bill_member['payout_bill_type']; ?>
  
  </td>
  <td height="12" align="left" valign="middle">&nbsp;   บาท</td>
      </tr>
<tr>
  <td height="13" colspan="7" align="center" valign="middle"><a href="module/shipment/reset_bill_member2.php?receipt_member_no=<?php echo  $colname_search_bill_member; ?>"class="btn-secondary" target="new">ยกเลิกใบค่าจ้างคนขับรถ</a></td>
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
mysql_free_result($search_bill_member);
?>
