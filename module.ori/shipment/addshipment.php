<?php require_once('../../Connections/ml.php'); ?>
<?php $jobnumber = "THE-1".date ("dmYHis"); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
//include ไฟล์ Upload เอกสาร
	include ("uploadshipment.php");
	
//จบไฟล์ Upload เอกสาร
  $insertSQL = sprintf("INSERT INTO shipment (transaction_date, product_payment_id, product_id, customer_id, customer_destination, product_dateout, drivermember_id, product_amount, rate_pricein_type1, rate_priceout_type1, rate_pricein_type2, rate_priceout_type2, rate_pricein_type3, rate_priceout_type3, comment, status, pictureorder) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['transaction_date'], "date"),
                       GetSQLValueString($_POST['product_payment_id'], "text"),
                       GetSQLValueString($_POST['product_id'], "text"),
                       GetSQLValueString($_POST['customer_id'], "text"),
                       GetSQLValueString($_POST['customer_destination'], "text"),
                       GetSQLValueString($_POST['product_dateout'], "date"),
                       GetSQLValueString($_POST['driver_id'], "text"),
                       GetSQLValueString($_POST['product_amount'], "int"),
                       GetSQLValueString($_POST['rate_pricein_type1'], "int"),
                       GetSQLValueString($_POST['rate_priceout_type1'], "int"),
                       GetSQLValueString($_POST['rate_pricein_type2'], "int"),
                       GetSQLValueString($_POST['rate_priceout_type2'], "int"),
                       GetSQLValueString($_POST['rate_pricein_type3'], "int"),
                       GetSQLValueString($_POST['rate_priceout_type3'], "int"),
                       GetSQLValueString($_POST['comment'], "text"),					   
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($newname, "text"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($insertSQL, $ml) or die(mysql_error());

  $insertGoTo = "addshipment2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_ml, $ml);
$query_addshipment = "SELECT * FROM shipment";
$addshipment = mysql_query($query_addshipment, $ml) or die(mysql_error());
$row_addshipment = mysql_fetch_assoc($addshipment);
$totalRows_addshipment = mysql_num_rows($addshipment);

mysql_select_db($database_ml, $ml);
$query_list_customer = "SELECT * FROM customer";
$list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
$row_list_customer = mysql_fetch_assoc($list_customer);
$totalRows_list_customer = mysql_num_rows($list_customer);

mysql_select_db($database_ml, $ml);
$query_list_product = "SELECT * FROM product";
$list_product = mysql_query($query_list_product, $ml) or die(mysql_error());
$row_list_product = mysql_fetch_assoc($list_product);
$totalRows_list_product = mysql_num_rows($list_product);

mysql_select_db($database_ml, $ml);
$query_list_drivermember = "SELECT * FROM drivermember";
$list_drivermember = mysql_query($query_list_drivermember, $ml) or die(mysql_error());
$row_list_drivermember = mysql_fetch_assoc($list_drivermember);
$totalRows_list_drivermember = mysql_num_rows($list_drivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>เพิ่มข้อมูลใบจ่ายสินค่า</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">

<!--Script ปฏิทินเลือกวันที่  -->
<script src="jquery-1.6.min.js" type="text/javascript"></script>
<script src="jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
<link href="plugin/datepiker/date/jquery-ui-1.8.12.custom.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript">
 //วันที่ทำรายการ
	$(document) .ready(function() {
		$("#date_1") .datepicker({
		dateFormat : "yy-mm-dd"
    });
  });   
 </script>
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
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form2">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">เพิ่มข้อมูลใบจ่ายสินค่า</td>
    </tr>
    <tr>
      <td align="center" valign="top"><table align="center">
        <tr valign="baseline">
          <td width="25%" align="right" nowrap><span class="small">เลขที่ใบจ่ายสินค้า:</span></td>
          <td width="25%"><span class="small">
            <input type="text" name="product_payment_id" value="<?php echo $jobnumber; ?>" size="32">
          </span></td>
          <td width="25%"><span class="small">วันที่ทำรายการ :</span></td>
          <td width="25%" bgcolor="#FFFFFF"><span class="small">
            <input name="transaction_date" type="text" id="date_1"   required="required" placeholder="click"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" align="right" nowrap><span class="small">ชื่อลูกค้า:</span></td>
          <td width="25%"><span class="small">
            <select name="customer_id" id="customer_id">
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
          </span></td>
          <td width="25%"><span class="small">ประเภทสินค้า:</span></td>
          <td width="25%"><span class="small">
            <select name="product_id" id="product_id">
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
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" rowspan="3" align="right" valign="top" nowrap><span class="small">สถานที่จัดส่ง:</span></td>
          <td width="25%" rowspan="3" valign="top"><span class="small">
            <textarea name="customer_destination" cols="32" rows="5"></textarea>
          </span></td>
          <td width="25%" valign="top"><span class="small">วันที่ให้ไปรับสินค้าต้นทาง:</span></td>
          <td width="25%" valign="top"><span class="small">
            <input name="product_dateout" type="text" id="date_2"   required="required" placeholder="click"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%"><span class="small">ชื่อผู้ขับรถไปรับสินค้าต้นทาง:</span></td>
          <td width="25%"><select name="driver_id" class="small" id="driver_id">
            <?php
do {  
?>
            <option value="<?php echo $row_list_drivermember['driver_id']?>"><?php echo $row_list_drivermember['driver_first_name'] ."  ". $row_list_drivermember['driver_last_name'] ?></option>
            <?php
} while ($row_list_drivermember = mysql_fetch_assoc($list_drivermember));
  $rows = mysql_num_rows($list_drivermember);
  if($rows > 0) {
      mysql_data_seek($list_drivermember, 0);
	  $row_list_drivermember = mysql_fetch_assoc($list_drivermember);
  }
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td width="25%"><span class="small">จำนวนที่รับสินค้า (ตัน) :</span></td>
          <td width="25%"><span class="small">
          <input type="text" name="product_amount" value="" size="32">
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" align="right" nowrap>&nbsp;</td>
          <td width="25%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td colspan="4" align="right" nowrap><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="small">ราคารับประเภท 1 :
                
              </span></td>
              <td><span class="small">
                <input type="text" name="rate_pricein_type1" value="" size="32">
              </span></td>
              <td><span class="small">ราคารับประเภท 2 :</span></td>
              <td><span class="small">
                <input type="text" name="rate_pricein_type2" value="" size="32">
              </span></td>
              <td><span class="small">ราคารับประเภท 3:</span></td>
              <td><span class="small">
                <input type="text" name="rate_pricein_type3" value="" size="32">
              </span></td>
            </tr>
            <tr>
              <td><span class="small">ราคาขายประเภท 1 :</span></td>
              <td><span class="small">
                <input type="text" name="rate_priceout_type1" value="" size="32">
              </span></td>
              <td><span class="small">ราคาขายประเภท 2 :</span></td>
              <td><span class="small">
                <input type="text" name="rate_priceout_type2" value="" size="32">
              </span></td>
              <td><span class="small">ราคาขายประเภท 3 :</span></td>
              <td><span class="small">
                <input type="text" name="rate_priceout_type3" value="" size="32">
              </span></td>
            </tr>
          </table></td>
          </tr>
        <tr valign="baseline">
          <td width="25%" align="right" nowrap><span class="small">จัดส่งในชื่อผู้จ้างภายนอก</span></td>
          <td width="25%"><span class="small">
            <input name="comment" type="text" id="comment" value="" size="32">
          </span></td>
          <td width="25%" align="right" nowrap><span class="small">อัพโหลดเอกสารใบสั่งของจากลูกค้า</span></td>
          <td width="25%"><input type="file" name="fileToUpload" id="fileToUpload"></td>
        </tr>
        <tr valign="baseline">
          <td colspan="4" align="center" valign="middle" nowrap><input name="status" type="hidden" id="status" value="99">            <input type="submit" value="บันทึกข้อมูล"> </td>
          </tr>
      </table></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addshipment);

mysql_free_result($list_customer);

mysql_free_result($list_product);

mysql_free_result($list_drivermember);
?>
