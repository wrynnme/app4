<?php require_once('../../Connections/ml.php'); ?>
<?php $jobnumber = "THE-1".date ("dmYHis");
 //$rndnumber = rand();
//ฟังก์ชั่นวันที่
    date_default_timezone_set('Asia/Bangkok');
	$date = date("Ymd");	
//ฟังก์ชั่นสุ่มตัวเลข
    $numrand = (mt_rand());
//สร้างไฟล์เพื่อ Upload เอกสาร	
	$filename = $date.$numrand;
?>
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
	include ("uploadfile.php");		
//จบไฟล์ Upload เอกสาร		
	
  $insertSQL = sprintf("INSERT INTO shipment (transaction_date, product_payment_id, type_product, customer_id, customer_destination, product_dateout, drivermember_id, product_amount, rate_pricein_type1, rate_priceout_type1, rate_pricein_type2, rate_priceout_type2, rate_pricein_type3, rate_priceout_type3, comment, status, pictureorder, ref_product_payment_id, comment2, customer_destination2, product_amount2, po_number, order_number, date3, comment3 , productsource) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s , %s)",
                       GetSQLValueString($_POST['transaction_date'], "date"),
                       GetSQLValueString($_POST['product_payment_id'], "text"),
                       GetSQLValueString($_POST['type_product'], "text"),
                       GetSQLValueString($_POST['customer_id'], "text"),
                       GetSQLValueString($_POST['customer_destination'], "text"),
                       GetSQLValueString($_POST['product_dateout'], "date"),
                       GetSQLValueString($_POST['driver_id'], "text"),
                       GetSQLValueString($_POST['product_amount'], "double"),
                       GetSQLValueString($_POST['rate_pricein_type1'], "double"),
                       GetSQLValueString($_POST['rate_priceout_type1'], "double"),
                       GetSQLValueString($_POST['rate_pricein_type2'], "double"),
                       GetSQLValueString($_POST['rate_priceout_type2'], "double"),
                       GetSQLValueString($_POST['rate_pricein_type3'], "double"),
                       GetSQLValueString($_POST['rate_priceout_type3'], "double"),
                       GetSQLValueString($_POST['comment'], "text"),					   
                       GetSQLValueString($_POST['status'], "int"),
					   GetSQLValueString($newname, "text"),
                       GetSQLValueString($_POST['ref_product_payment_id'], "text"),
					   GetSQLValueString($_POST['comment2'], "text"),
					   GetSQLValueString($_POST['customer_destination2'], "text"),
					   GetSQLValueString($_POST['product_amount2'], "int"),
					   GetSQLValueString($_POST['po_number'], "text"),
					   GetSQLValueString($_POST['order_number'], "text"),
					   GetSQLValueString($_POST['date3'], "date"),
					   GetSQLValueString($_POST['comment3'], "text"),
					   GetSQLValueString($_POST['productsource'], "text"));


  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($insertSQL, $ml) or die(mysql_error());

  $insertGoTo = "addshipment2.php?product_payment_id='".$_POST['product_payment_id']."'";
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

/*
mysql_select_db($database_ml, $ml);
$query_list_product = "SELECT * FROM product";
$list_product = mysql_query($query_list_product, $ml) or die(mysql_error());
$row_list_product = mysql_fetch_assoc($list_product);
$totalRows_list_product = mysql_num_rows($list_product);
*/

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

<!--Script ค้นหาข้อมูลแสดงใน Listbox  -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="dist/css/bootstrap-select.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="dist/js/bootstrap-select.js"></script>
<!--END Script ค้นหาข้อมูลแสดงใน Listbox  -->

<!--Script ปฏิทินเลือกวันที่  -->
<script src="jquery-1.6.min.js" type="text/javascript"></script>
<script src="jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
<link href="jquery-ui-1.8.12.custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #CCC;
}
</style>
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
  <script type="text/javascript">
 //วันที่ส่งสินค้าถึงปลายทาง
	$(document) .ready(function() {
		$("#date_3") .datepicker({
		dateFormat : "yy-mm-dd"
    });
  });   
 </script>
<!--End Script ปฏิทินเลือกวันที่  -->

<!--แสดงการเลือกที่อยู่แบบ จังหวัด อำเภอ ตำบล

<link rel="stylesheet" type="text/css" href="postaddreess/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="postaddreess/css/validationEngine.jquery.css" />

<script type="text/javascript" src="postaddreess/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="postaddreess/js/jquery-1.9.2.ui.jsxx"></script>
<script type="text/javascript" src="postaddreess/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="postaddreess/js/jquery.validationEngine-en.js"></script>
<script>
$().ready(function() {
	jQuery(".frmInsert").validationEngine();
});
</script>-->
<!--END แสดงการเลือกที่อยู่แบบ จังหวัด อำเภอ ตำบล-->

</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form2">
  <br>
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">เพิ่มข้อมูลใบจ่ายสินค่า</td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC"><table align="center">
        <tr valign="baseline">
          <td width="25%" align="right" nowrap bgcolor="#FFCCFF"><span class="small">เลขที่ใบจ่ายสินค้า:</span></td>
          <td width="25%" bgcolor="#FFCCFF"><span class="small">
            <input name="product_payment_id" type="text" value="<?php echo $jobnumber; ?>" size="32" readonly>
          </span></td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">วันที่ทำรายการ :</span></td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">
            <input name="transaction_date" type="text" id="date_1"   required="required" placeholder="click"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" align="right" nowrap bgcolor="#FFCCFF"><span class="small">ชื่อลูกค้า:</span></td>
          <td width="25%" bgcolor="#FFCCFF"><span class="small">
            <select name="customer_id" id="customer_id" class="selectpicker" data-live-search="true">
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
          <td width="25%" bgcolor="#CCFFFF" class="small">ข้อมูลเลขที่ตั๋ว</td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">
            <input name="ref_product_payment_id" type="text" id="ref_product_payment_id" required placeholder="ข้อมูลเลขที่ตั๋ว"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" rowspan="4" align="right" valign="top" nowrap bgcolor="#FFCCFF"><span class="small">หมายเลขโทรศัพท์ติดต่อ:</span></td>
          <td width="25%" rowspan="4" valign="top" bgcolor="#FFCCFF"><span class="small">
            <input name="customer_destination" type="text" value="" size="32">
          </span></td>
          <td width="25%" bgcolor="#CCFFFF" class="small">หมายเลขใบ PO</td>
          <td bgcolor="#CCFFFF"><span class="small">
            <input name="po_number" type="text" id="po_number" placeholder="หมายเลขใบ PO"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" bgcolor="#CCFFFF" class="small">หมายเลขใบสั่งซื้อ</td>
          <td bgcolor="#CCFFFF"><span class="small">
            <input name="order_number" type="text" id="order_number" placeholder="หมายเลขใบสั่งซื้อ"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" valign="top" bgcolor="#CCFFFF"><span class="small">ประเภทสินค้า:</span></td>
          <td width="25%" valign="top" bgcolor="#CCFFFF"><span class="small">
            <input type="text" name="type_product" id="type_product">
          </span></td>
        </tr>
        <tr valign="baseline">
          <td valign="top" bgcolor="#CCFFFF" class="small">สถานที่รับสินค้าต้นทาง</td>
          <td width="25%" valign="top" bgcolor="#CCFFFF"><span class="small"><input name="productsource" type="text" id="productsource"> </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" align="right" valign="top" nowrap bgcolor="#FFCCFF"><span class="small">&nbsp;ชื่่อย่อสถานที่ปลายทาง :</span></td>
          <td width="25%" valign="top" bgcolor="#FFCCFF"><span class="small">
            <input name="customer_destination2" type="text" id="customer_destination2" value="" size="32">
          </span></td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">วันที่ให้ไปรับสินค้าต้นทาง:</span></td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">
            <input name="product_dateout" type="text" id="date_2"   required="required" placeholder="click"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" rowspan="3" align="right" valign="top" nowrap bgcolor="#FFCCFF" class="small">หมายเหตุเพิ่มเติม&nbsp;:</td>
          <td width="25%" rowspan="3" valign="top" bgcolor="#FFCCFF"><span class="small">
            <textarea name="comment3" cols="32" rows="5" id="comment3"></textarea>
          </span></td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">วันกำหนดส่งสินค้าถึงปลายทาง:</span></td>
          <td bgcolor="#CCFFFF"><span class="small">
            <input name="date3" type="text" id="date_3"   required="required" placeholder="click"/>
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" bgcolor="#CCFFFF"><span class="small">ชื่อผู้ขับรถไปรับสินค้าต้นทาง:</span></td>
          <td width="25%" bgcolor="#CCFFFF"><select name="driver_id" id="driver_id" class="selectpicker" data-live-search="true" >
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
          <td bgcolor="#CCFFFF"><span class="small">จำนวนที่รับสินค้า (ตัน) :</span></td>
          <td bgcolor="#CCFFFF"><span class="small">
            <input type="text" name="product_amount" value="" size="32">
          </span></td>
        </tr>
        <tr valign="baseline">
          <td width="25%" align="right" nowrap bgcolor="#FFCCFF">&nbsp;</td>
          <td width="25%" bgcolor="#FFCCFF">&nbsp;</td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">จำนวนที่รับสินค้า (ถุง) :</span></td>
          <td width="25%" bgcolor="#CCFFFF"><span class="small">
            <input type="text" name="product_amount2" value="" size="32">
          </span></td>
        </tr>
        <tr valign="baseline">
          <td colspan="4" align="center" valign="top" nowrap><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="right" bgcolor="#FFCC00">&nbsp;</td>
              <td bgcolor="#FFCC00">&nbsp;</td>
              <td align="right" bgcolor="#FFCC00">&nbsp;</td>
              <td colspan="3" align="center" bgcolor="#FFCC66" class="small">กรณีจ้างเหมาเพิ่มเติม<br>
                (ย้ายจุด / เกินระยะทาง) กรุณระบุ</td>
              </tr>
            <tr>
              <td width="23%" align="right" valign="bottom" bgcolor="#FFCC00"><span class="small">ราคาตกลงขายให้ลูกค้าประเภท 1 :
                
              </span></td>
              <td width="14%" align="right" valign="bottom" bgcolor="#FFCC00"><span class="small">
                <input type="text" name="rate_pricein_type1" value="" size="10">
             &nbsp;บาท</span></td>
              <td width="4%" align="right" bgcolor="#FFCC00">&nbsp;</td>
              <td width="15%" valign="bottom" bgcolor="#FFCC66"><span class="small">ราคาตกลงกับลูกค้า</span></td>
              <td width="13%" align="right" valign="bottom" bgcolor="#FFCC66" class="small"><input type="text" name="rate_pricein_type3" value="" size="10">
                บาท</td>
              <td width="31%" rowspan="2" align="center" valign="top" bgcolor="#FFCC66" class="small"><span class="small">
                <textarea name="comment2" cols="40" rows="5" id="comment2"></textarea>
              </span></td>
              </tr>
            <tr>
              <td width="23%" align="right" valign="bottom" bgcolor="#FFCC00"><span class="small">ราคาจ้างผู้ขับรถส่งสินค้าประเภท 1 :</span></td>
              <td width="14%" align="right" valign="bottom" bgcolor="#FFCC00"><span class="small">
                <input type="text" name="rate_priceout_type1" value="" size="10">
              &nbsp;บาท</span></td>
              <td width="4%" align="right" bgcolor="#FFCC00">&nbsp;</td>
              <td width="15%" valign="bottom" bgcolor="#FFCC66"><span class="small">ราคาจ้างกับผู้ส่งสินค้า</span></td>
              <td width="13%" align="right" valign="bottom" bgcolor="#FFCC66"><span class="small">
                <input type="text" name="rate_priceout_type3" value="" size="10">
                &nbsp;บาท</span></td>
              </tr>
            <tr>
              <td align="right" valign="bottom" bgcolor="#FFCC00">&nbsp;</td>
              <td align="right" valign="bottom" bgcolor="#FFCC00">&nbsp;</td>
              <td align="right" bgcolor="#FFCC00">&nbsp;</td>
              <td valign="bottom" bgcolor="#FFCC66">&nbsp;</td>
              <td align="right" valign="bottom" bgcolor="#FFCC66">&nbsp;</td>
              <td align="center" valign="top" bgcolor="#FFCC66" class="small">&nbsp;</td>
            </tr>
          </table></td>
          </tr>
        <tr valign="baseline">
          <td width="25%" align="right" nowrap bgcolor="#CCCCFF" class="small">สั่งผ่าน</td>
          <td width="25%" bgcolor="#CCCCFF"><span class="small">
            <input name="comment" type="text" id="comment" value="" size="25">
          </span></td>
          <td width="25%" align="right" nowrap bgcolor="#CCCCFF"><span class="small">อัพโหลดเอกสารใบสั่งของจากลูกค้า</span></td>
          <td width="25%" bgcolor="#CCCCFF"><input name="fileupload" type="file" id="fileupload" size="25" maxlength="255"></td>
        </tr>
        <tr valign="baseline">
          <td colspan="4" align="center" valign="middle" nowrap bgcolor="#FFFFCC"><span class="small">
            <input type="hidden" name="rate_priceout_type2" id="rate_priceout_type2">
            <input type="hidden" name="rate_pricein_type2" id="rate_pricein_type2">
          </span>
            <input name="status" type="hidden" id="status" value="99">            <input type="submit" value="บันทึกข้อมูล"> </td>
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
