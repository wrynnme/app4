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
  $updateSQL = sprintf("UPDATE shipment SET transaction_date=%s, product_payment_id=%s, product_id=%s, customer_name=%s, customer_destination=%s, product_dateout=%s, product_amount=%s, rate_pricein_type1=%s, rate_priceout_type1=%s, rate_pricein_type2=%s, rate_priceout_type2=%s, rate_pricein_type3=%s, rate_priceout_type3=%s, `comment`=%s, status=%s WHERE id=%s",
                       GetSQLValueString($_POST['transaction_date'], "date"),
                       GetSQLValueString($_POST['product_payment_id'], "text"),
                       GetSQLValueString($_POST['product_id'], "text"),
                       GetSQLValueString($_POST['customer_name'], "text"),
                       GetSQLValueString($_POST['customer_destination'], "text"),
                       GetSQLValueString($_POST['product_dateout'], "date"),
                       GetSQLValueString($_POST['product_amount'], "text"),
                       GetSQLValueString($_POST['rate_pricein_type1'], "text"),
                       GetSQLValueString($_POST['rate_priceout_type1'], "text"),
                       GetSQLValueString($_POST['rate_pricein_type2'], "text"),
                       GetSQLValueString($_POST['rate_priceout_type2'], "text"),
                       GetSQLValueString($_POST['rate_pricein_type3'], "text"),
                       GetSQLValueString($_POST['rate_priceout_type3'], "text"),
                       GetSQLValueString($_POST['comment'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());

  $updateGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editshipment = "-1";
if (isset($_GET['id'])) {
  $colname_editshipment = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_editshipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_editshipment, "int"));
$editshipment = mysql_query($query_editshipment, $ml) or die(mysql_error());
$row_editshipment = mysql_fetch_assoc($editshipment);
$totalRows_editshipment = mysql_num_rows($editshipment);

mysql_select_db($database_ml, $ml);
$query_list_product = "SELECT * FROM product";
$list_product = mysql_query($query_list_product, $ml) or die(mysql_error());
$row_list_product = mysql_fetch_assoc($list_product);
$totalRows_list_product = mysql_num_rows($list_product);

mysql_select_db($database_ml, $ml);
$query_jobstatus = "SELECT * FROM jobstatus";
$jobstatus = mysql_query($query_jobstatus, $ml) or die(mysql_error());
$row_jobstatus = mysql_fetch_assoc($jobstatus);
$totalRows_jobstatus = mysql_num_rows($jobstatus);

/*
		สถานะ 99 = เปิดบิลใหม่
		สถานะ 0 = รอพิมพ์ใบส่งสินค้า
		สถานะ 1 = พิมพ์ใบส่งสินค้าแล้ว
		สถานะ 2 = สินค้าส่งเรียบร้อยแล้วรอการเรียกเก็บเงิน
		สถานะ 3 = ออกใบตั้งเบิกแล้ว
		สถานะ 4 = ออกใบเสร็จเรียกเก็บเงินแล้ว
		สถานะ 5 = รับเงินจากลูกค้าแล้ว
		สถานะ 6 = ออกใบจ่ายค่าจ้างแก่คนขับรถส่งของแล้ว
*/

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>แก้ไขใบสั่งสินค้า</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<!--<link rel= "stylesheet" href="bootstrap/css/bootstrap.css"> -->

<!--Script ปฏิทินเลือกวันที่  -->
<script src="jquery-1.6.min.js" type="text/javascript"></script>
<script src="jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
<link href="jquery-ui-1.8.12.custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #999;
}
</style>
 <script type="text/javascript">
 //วันที่ให้ไปรับสินค้าต้นทาง
	$(document) .ready(function() {
		$("#date_2") .datepicker({
		dateFormat : "yy-mm-dd"
    });
  });   
 </script>
<!--End Script ปฏิทินเลือกวันที่  -->

</head>

<body>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="3">แก้ไขข้อมูล
       </td>
    </tr>
    <tr>
      <td width="15%">สถานะเอกสาร</td>
      <td width="35%">
      <?php
			//echo $row_editshipment['status'];
			switch ($row_editshipment['status']){
			case "0" : $job_status = "รอพิมพ์ใบส่งสินค้า";
						break;
			case "1" : $job_status = "พิมพ์ใบส่งสินค้าแล้ว";
						break;
			case "2" : $job_status = "สินค้าส่งเรียบร้อยแล้วรอการเรียกเก็บเงิน";
						break;
			case "3" : $job_status = "ออกใบตั้งเบิกแล้ว";
						break;
			case "4" : $job_status = "ออกใบเสร็จเรียกเก็บเงินแล้ว";
						break;
			case "5" : $job_status = "รับเงินจากลูกค้าแล้ว";
						break;
			case "6" : $job_status = "ออกใบจ่ายค่าจ้างแก่คนขับรถส่งของแล้ว";
						break;											
			}
		?>
      <input type="hidden" name="id" value="<?php echo $row_editshipment['id']; ?>">
      <select name="status" id="select" title="<?php echo $row_editshipment['status']; ?>">
        <option value="<?php echo $row_editshipment['status']?>"><?php echo $job_status; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_jobstatus['status']?>"><?php echo $row_jobstatus['jobname']?></option>
        <?php
} while ($row_jobstatus = mysql_fetch_assoc($jobstatus));
  $rows = mysql_num_rows($jobstatus);
  if($rows > 0) {
      mysql_data_seek($jobstatus, 0);
	  $row_jobstatus = mysql_fetch_assoc($jobstatus);
  }
?>
      </select></td>
      <td width="50%">
	  	
      
      </td>
    </tr>
    <tr>
      <td>หมายเลขใบส่งสินค้า</td>
      <td><input name="product_payment_id" type="text" disabled  value="<?php echo $row_editshipment['product_payment_id']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>แนบไฟล์เอกสาร</td>
      <td><?php echo $row_editshipment['imagejobnumber']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>วันที่ทำรายการ</td>
      <td><input name="transaction_date" type="text" disabled  value="<?php echo $row_editshipment['transaction_date']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ชื่อลูกค้า</td>
      <td><input name="customer_name" type="text" disabled  value="<?php echo $row_editshipment['customer_name']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ที่อยู่สำหรับการจัดส่ง</td>
      <td><textarea name="customer_destination" cols="35" rows="5" ><?php echo $row_editshipment['customer_destination']; ?></textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ประเภทสินค้า</td>
      <td>
      <span class="small">
                    <select name="product_id" class="list-group" id="product_id">
                    <option value="<?php echo $row_editshipment['product_id']; ?>"><?php echo $row_editshipment['type_product']; ?></option>
                    
                        <?php
                        do {  
                        ?>
                        <option value="<?php echo $row_list_product['product_id']?>"><?php echo $row_list_product['product_name']?></option>
                        <?php
                        } while ($row_list_product = mysql_fetch_assoc($list_product));
                          $rows = mysql_num_rows($list_product);
                          if($rows > 0) {
                              mysql_data_seek($list_product, 0);
                              $row_list_product = mysql_fetch_assoc($list_product);
                          }
                        ?>
                    </select>
	</span>      
      </td>
      <td></td>
    </tr>
    <tr>
      <td>วันที่รับสินค้า</td>
      <td><span class="small">
                	<input name="product_dateout" type="text" id="date_2" value="<?php echo $row_editshipment['product_dateout']; ?>" required placeholder="click"/>
					</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>จำนวน (ตัน)</td>
      <td><input name="product_amount" type="text" id="textfield6" value="<?php echo $row_editshipment['product_amount']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ชื่อผู้จัดส่งภายนอก</td>
      <td><input type="text" name="comment" id="textfield7" value="<?php echo $row_editshipment['comment']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">ราคาขาย</td>
    </tr>
    <tr>
      <td>ราคารับประเภท 1</td>
      <td><input name="rate_pricein_type1" type="text" id="textfield8" value="<?php echo $row_editshipment['rate_pricein_type1']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ราคาขายประเภท 1</td>
      <td><input name="rate_priceout_type1" type="text" id="textfield9" value="<?php echo $row_editshipment['rate_priceout_type1']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ราคารับประเภท 2</td>
      <td><input name="rate_pricein_type2" type="text" id="textfield10" value="<?php echo $row_editshipment['rate_pricein_type2']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ราคาขายประเภท 2</td>
      <td><input name="rate_priceout_type2" type="text" id="textfield11" value="<?php echo $row_editshipment['rate_priceout_type2']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ราคารับประเภท 3</td>
      <td><input name="rate_pricein_type3" type="text" id="textfield12" value="<?php echo $row_editshipment['rate_pricein_type3']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>ราคาขายประเภท 3</td>
      <td><input name="rate_priceout_type3" type="text" id="textfield13" value="<?php echo $row_editshipment['rate_priceout_type3']; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="ปรับปรุงข้อมูล"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($editshipment);

mysql_free_result($list_product);

mysql_free_result($jobstatus);
?>
