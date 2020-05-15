<?php //require_once('../../Connections/ml.php'); 
?>
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

$colname_search_receipt = "-1";
if (isset($_POST['receipt_id'])) {
  $colname_search_receipt = $_POST['receipt_id'];
}
mysql_select_db($database_ml, $ml);
$query_search_receipt = sprintf("SELECT * FROM receipt WHERE receipt_id = %s", GetSQLValueString($colname_search_receipt, "text"));
$search_receipt = mysql_query($query_search_receipt, $ml) or die(mysql_error());
$row_search_receipt = mysql_fetch_assoc($search_receipt);
$totalRows_search_receipt = mysql_num_rows($search_receipt);
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Untitled Document</title>
</head>

<body>
  <form name="form1" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td>
          <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="45" align="center" bgcolor="#00CCFF">ยกเลิกเอกสารใบเสร็จรับเงิน</td>
            </tr>
            <tr>
              <td height="45" align="center" bgcolor="#FFFFCC"><label for="receipt_id">กรุณาใส่เลขที่ เอกสารใบเสร็จรับเงิน &nbsp;</label>
                <input type="text" name="receipt_id" id="receipt_id"></td>
            </tr>
            <tr>
              <td height="45" align="center" bgcolor="#FFFFCC"><input type="submit" name="Submit" id="Submit" value="ค้นหาข้อมูล"></td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="35" colspan="5" align="center" bgcolor="#FFCC00">
                <p>ข้อมูลเอกสารใบเสร็จรับเงินที่จะยกเลิก [หมายเลขใบเสร็จ : <?php echo $colname_search_receipt; ?> ]</p>
                <?php
                //เรียกฐานข้อมูลลูกค้าเพื่อใช้ในการชื่อลูกค้า
                mysql_select_db($database_ml, $ml);
                $query_list_customer = "SELECT * FROM customer WHERE id = " . $row_search_receipt['customer_id'];
                //echo $query_list_customer;
                $list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
                $row_list_customer = mysql_fetch_assoc($list_customer);
                $totalRows_list_customer = mysql_num_rows($list_customer);
                //สิ้นสุดเรียกฐานข้อมูลลูกค้าเพื่อใช้ในการชื่อลูกค้า		  		  
                echo "<p>ชื่อผู้ซื้อ : " . $row_list_customer['name'] . "</p>";
                echo "<p>" . $row_search_receipt['round_shipment'] . "</p>";
                ?>
              </td>
            </tr>
            <tr>
              <td width="16%" height="25" align="center" valign="middle" bgcolor="#FFCC99">เลขที่ใบแจ้งหนี้</td>
              <td width="24%" height="25" align="center" valign="middle" bgcolor="#FFCC99">วันที่ออกใบเสร็จ</td>
              <td width="25%" align="center" valign="middle" bgcolor="#FFCC99">รายการ</td>
              <td width="23%" height="25" align="center" valign="middle" bgcolor="#FFCC99">จำนวนเงิน</td>
              <td width="12%" height="25" align="center" valign="middle" bgcolor="#FFCC99"><a href="module/shipment/reset_receipt2.php?receipt_id=<?php echo $colname_search_receipt ?>" class="btn-secondary" target="new">ยกเลิกใบเสร็จรับเงิน</a></td>
            </tr>
            <?php do { ?>
              <tr>
                <td height="25" align="left" valign="middle"><?php echo $row_search_receipt['billing_id']; ?></td>
                <td height="25" valign="middle"><?php echo $row_search_receipt['transaction_date']; ?>

                </td>
                <td height="25" valign="middle">ค่าขนส่ง</td>
                <td height="25" align="right" valign="center"><?php echo number_format($row_search_receipt['amount'] + $row_search_receipt['amount2'], 2); ?></td>
                <td height="25" align="center" valign="middle">&nbsp;</td>
                <?php
                $totalamount = $totalamount +  $row_search_receipt['amount'];
                $totalamount2 = $totalamount2 + $row_search_receipt['amount2'];
                $totalall = $totalamount + $totalamount2;
                ?>
              </tr>
            <?php } while ($row_search_receipt = mysql_fetch_assoc($search_receipt)); ?>
            <tr>
              <td height="12" colspan="3" align="right" valign="middle" bgcolor="#CCFFFF">รวมเงิน </td>
              <td height="12" align="right" valign="middle" bgcolor="#CCFFFF"><?php echo number_format($totalall, 2); ?></td>
              <td height="12" align="center" valign="middle" bgcolor="#CCFFFF">บาท</td>
            </tr>
            <tr>
              <td height="13" colspan="5" align="center" valign="middle"><a href="module/shipment/reset_receipt2.php?receipt_id=<?php echo $colname_search_receipt ?>" class="btn-secondary" target="new">ยกเลิกใบเสร็จรับเงิน</a></td>
            </tr>
          </table>
        </td>
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
mysql_free_result($search_receipt);
?>