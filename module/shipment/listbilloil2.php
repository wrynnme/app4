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

$colname_showshipment = "-1";
if (isset($_GET['product_payment_id'])) {
  $colname_showshipment = $_GET['product_payment_id'];
}
mysql_select_db($database_ml, $ml);
$query_showshipment = sprintf("SELECT * FROM shipment WHERE product_payment_id = %s", GetSQLValueString($colname_showshipment, "text"));
$showshipment = mysql_query($query_showshipment, $ml) or die(mysql_error());
$row_showshipment = mysql_fetch_assoc($showshipment);
$totalRows_showshipment = mysql_num_rows($showshipment);

mysql_select_db($database_ml, $ml);
$query_listbilloil = "SELECT * FROM receipt_member";
$listbilloil = mysql_query($query_listbilloil, $ml) or die(mysql_error());
$row_listbilloil = mysql_fetch_assoc($listbilloil);
$totalRows_listbilloil = mysql_num_rows($listbilloil);

mysql_select_db($database_ml, $ml);
$query_listdrivermember = "SELECT * FROM drivermember WHERE driver_id =".$row_showshipment['drivermember_id'];
$listdrivermember = mysql_query($query_listdrivermember, $ml) or die(mysql_error());
$row_listdrivermember = mysql_fetch_assoc($listdrivermember);
$totalRows_listdrivermember = mysql_num_rows($listdrivermember);

mysql_select_db($database_ml, $ml);
$query_search_bill_oil = "SELECT * FROM receipt_member WHERE product_payment_id LIKE '".$colname_showshipment."'";
$search_bill_oil = mysql_query($query_search_bill_oil, $ml) or die(mysql_error());
$row_listbilloil = mysql_fetch_assoc($search_bill_oil);
$totalRows_listbilloil = mysql_num_rows($search_bill_oil);
//echo $totalRows_listbilloil;
if($totalRows_listbilloil == 0)
{
	$status_bill_oil_error = 0;
//	echo "พิมพ์ข้อมูลได้";
}
else
{
	$status_bill_oil_error = 1;	
//	echo "พิมพ์ข้อมูลไม่ได้";
}



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$payout_oil_bill_no = $_POST["payout_oil_bill_no1"]."/".$_POST["payout_oil_bill_no2"];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
			
		$insertSQL = sprintf("INSERT INTO receipt_member (member_id, product_payment_id, ref_product_payment_id, payout_oil_bill_no, payout_oil_date, payout_oil_bill_comment, payout_oil_bill_total, receipt_member_total) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['member_id'], "text"),
						   GetSQLValueString($_POST['product_payment_id'], "text"),
						   GetSQLValueString($_POST['ref_product_payment_id'], "text"),
						   GetSQLValueString($payout_oil_bill_no, "text"),
						   GetSQLValueString($_POST['payout_oil_date'], "date"),
						   GetSQLValueString($_POST['payout_oil_bill_comment'], "text"),
						   GetSQLValueString($_POST['payout_oil_bill_total'], "double"),
						   GetSQLValueString($_POST['receipt_member_total'], "double"));
		
		mysql_select_db($database_ml, $ml);
		$Result1 = mysql_query($insertSQL, $ml) or die(mysql_error());
		
		$status_oil = "1";
		$new_status = "4";
		//UPdate ข้อมูลการบันทึกน้ำมันที่ตาราง shipment
		$update1SQL = sprintf("UPDATE shipment SET status_oil=%s WHERE product_payment_id=%s",
						   GetSQLValueString($status_oil, "text"),
						   GetSQLValueString($_POST['product_payment_id'], "text"));					   	   
		mysql_select_db($database_ml, $ml);
		$Result1 = mysql_query($update1SQL, $ml) or die(mysql_error());
		//จบ UPdate ข้อมูลการบันทึกน้ำมันที่ตาราง shipment
		
		//ปรับสถานะเอกสารเป็นรอพิมพ์ใบสลิปค่าจ้าง	
		$update2SQL = sprintf("UPDATE shipment SET status=%s WHERE id=%s",                       
						   GetSQLValueString($new_status, "int"),
						   GetSQLValueString($_POST['product_payment_id'], "int"));					   
		mysql_select_db($database_ml, $ml);
		$Result1 = mysql_query($update2SQL, $ml) or die(mysql_error());
		//จบปรับสถานะเอกสารเป็นรอพิมพ์ใบเสร็จรับเงิน
		
		
		//  $insertGoTo = "index.php?pagename=listbilloil";
		$insertGoTo = "../member/closewindows.php";
		if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		header(sprintf("Location: %s", $insertGoTo));
		}

/* 
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
*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="285" align="center" valign="top"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
      <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="6" align="center" bgcolor="#FFCC00">
          	บันทึกการเบิกเงินค่าน้ำมัน
            <?php 
				if ($status_bill_oil_error == 1)
				{
					echo "<p><font color=FF0000>  หมายเลขใบส่งสินค้านี้ถูกบันทึกข้อมูลแล้ว หากต้องการแก้ไขกรุณายกเลิกเอกสารข้อมูลบันทึกเบิกน้ำมันก่อน ที่หัวข้อยกเลิกเอกสาร</p></font>";
					echo "<p><a href='closewindows.php'>คลิกเพื่อปิดหน้าต่างนี้</a></p>";					
				} 
			?>
          	
          </td>
        </tr>
        <tr>
          <td width="37%" bgcolor="#CCCCFF">เลขที่ใบส่งสินค้า : <?php echo $row_showshipment['product_payment_id']; ?></td>
          <td colspan="5" align="center" bgcolor="#33FFFF">บันทึกใบเสร็จค่าน้ำมันและอื่นๆ</td>
        </tr>
        <tr>
        	<td width="37%" bgcolor="#CCCCFF">เลขที่ตั๋วสินค้า : <?php echo $row_showshipment['ref_product_payment_id']; ?>
            <input name="ref_product_payment_id" type="hidden" id="ref_product_payment_id" value="<?php echo $row_showshipment['ref_product_payment_id']; ?>"> </td>
            <td colspan="5" align="center" bgcolor="#FFFFCC"></td>
        </tr>
        <tr>
          <td width="37%" bgcolor="#CCCCFF">ประเภทสินค้า : <?php echo $row_showshipment['type_product']; ?></td>
          <td width="18%" bgcolor="#FFFFCC">วันที่บันทึกข้อมูล</td>
          <td colspan="4" bgcolor="#FFFFCC"><?php $payout_oil_date = date("d/m/Y"); echo $payout_oil_date; ?> </td>
        </tr>
        <tr>
          <td width="37%" bgcolor="#CCCCFF">สถานที่รับต้นทาง : <?php echo $row_showshipment['productsource']; ?></td>
          <td width="18%" bgcolor="#FFFFCC">เลขที่ใบเสร็จน้ำมัน</td>
          <td width="12%" align="center" bgcolor="#FFFFCC">เล่มใบเสร็จ </td>
          <td width="6%" align="center" bgcolor="#FFFFCC"><input name="payout_oil_bill_no1" type="text" id="payout_oil_bill_no1" size="10" maxlength="10" 
		<?php 
		  	if ($status_bill_oil_error == 1)
		  	{ 
				echo "readonly value = '".$row_listbilloil['payout_oil_bill_no']."'";				
			}
		?>
        >          
          </td>
          <td width="11%" align="right" bgcolor="#FFFFCC">เลขที่ใบเสร็จ</td>
          <td width="16%" align="center" bgcolor="#FFFFCC"><input name="payout_oil_bill_no2" type="text" id="payout_oil_bill_no2" size="10" maxlength="10" 
		  <?php 
		  	if ($status_bill_oil_error == 1)
			{
				 echo "readonly";
			}?> 
        >
        </td>
        </tr>
        <tr>
          <td width="37%" bgcolor="#CCCCFF">สถานที่ส่งสินค้า : <?php echo $row_showshipment['customer_destination']; ?></td>
          <td width="18%" bgcolor="#FFFFCC">ประเภทน้ำมัน</td>
          <td colspan="4" bgcolor="#FFFFCC"><input name="payout_oil_bill_comment" type="text" id="payout_oil_bill_comment" size="35" maxlength="50" 
		<?php 
		  	if ($status_bill_oil_error == 1)
		  	{ 
				echo "readonly value = '".$row_listbilloil['payout_oil_bill_comment']."'";				
			}
		?>
         >
         </td>
        </tr>
        <tr>
          <td width="37%" bgcolor="#CCCCFF">ค่าจ่างขนส่ง : <?php echo $row_showshipment['rate_priceout_type1']; ?>&nbsp;บาท</td>
          <td width="18%" bgcolor="#FFFFCC">จำนวนเงิน</td>
          <td colspan="4" bgcolor="#FFFFCC"><input name="payout_oil_bill_total" type="text" id="payout_oil_bill_total" size="10" maxlength="10" 
		<?php 
		  	if ($status_bill_oil_error == 1)
		  	{ 
				echo "readonly value = '".$row_listbilloil['payout_oil_bill_total']."'";				
			}
		?> 
           >          
            บาท</td>
        </tr>
        <tr>
          <td width="37%" bgcolor="#CCCCFF">ค่าจ้างเพิ่มเติม&nbsp;: <?php echo $row_showshipment['rate_priceout_type3']; ?>&nbsp;บาท</td>
          <td width="18%" bgcolor="#FFFFCC"><input name="member_id" type="hidden" id="member_id" value="<?php echo $row_showshipment['drivermember_id']; ?>">
            <input name="product_payment_id" type="hidden" id="product_payment_id" value="<?php echo $row_showshipment['product_payment_id']; ?>">
            <input name="payout_oil_date" type="hidden" id="payout_oil_date" value="<?php echo date("Y/m/d");?>">            
            <input name="receipt_member_total" type="hidden" id="receipt_member_total" value="<?php echo $row_showshipment['rate_priceout_type1']; ?>">
          </td
          ><td colspan="4" bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr>
          <td width="37%" bgcolor="#CCCCFF">เลขทะเบียรถ : <?php echo $row_showshipment['car_id']; ?></td>
          <td colspan="5" align="center" bgcolor="#FFFFCC"><input type="hidden" name="MM_insert" value="form1"><input type="submit" name="button" id="button" value="บันทึกข้อมูล" <?php if ($status_bill_oil_error == 1) { echo "disabled"; }?> ></td>
        </tr>
        <tr>
          <td bgcolor="#CCCCFF">ชื่อคนขับรถ :&nbsp; <?php echo $row_listdrivermember['driver_first_name']."&nbsp;&nbsp;&nbsp;". $row_listdrivermember['driver_last_name']  ?></td>
          <td colspan="5" align="center" bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
      </table>
      
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($showshipment);

mysql_free_result($listbilloil);

mysql_free_result($listdrivermember);
?>
