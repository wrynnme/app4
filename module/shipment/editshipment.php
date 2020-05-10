<?php require_once('../../Connections/ml.php'); ?>
<?php 
//$jobnumber = "THE-1".date ("dmYHis");
 //$rndnumber = rand();
//ฟังก์ชั่นวันที่
    date_default_timezone_set('Asia/Bangkok');
	$date = date("Ymd");	
//ฟังก์ชั่นสุ่มตัวเลข
    $numrand = (mt_rand());
//สร้างไฟล์เพื่อ Upload เอกสาร	
	$filename = $date.$numrand;
	$filename2 = "status2-".$date.$numrand;
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



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

	include "uploadfile.php";
	
	if ($newname == "")
	{
		$newname = $_POST["pictureorder-ori"];
	}
	
	if ($newname2 == "")
	{
		$newname2 = $_POST["picturestatus2-ori"];
	}
	
	

	$updateSQL = sprintf("UPDATE shipment SET product_id=%s, customer_destination=%s, product_dateout=%s, drivermember_id=%s, product_amount=%s, rate_pricein_type1=%s, rate_priceout_type1=%s, rate_pricein_type3=%s, `comment`=%s, pictureorder=%s, status=%s, picturestatus2=%s, customer_destination2=%s, product_amount2=%s, po_number=%s, order_number=%s, ref_product_payment_id=%s, comment3=%s, date3=%s , type_product=%s , productsource=%s , comment2 = %s , rate_pricein_type3 = %s , rate_priceout_type3 = %s WHERE id=%s",
                       GetSQLValueString($_POST['product_id'], "text"),
                       GetSQLValueString($_POST['customer_destination'], "text"),
                       GetSQLValueString($_POST['product_dateout'], "date"),
                       GetSQLValueString($_POST['drivermember_id'], "text"),
                       GetSQLValueString($_POST['product_amount'], "double"),
                       GetSQLValueString($_POST['rate_pricein_type1'], "double"),
                       GetSQLValueString($_POST['rate_priceout_type1'], "double"),
                       GetSQLValueString($_POST['rate_pricein_type3'], "double"),
                       GetSQLValueString($_POST['comment'], "text"),
                       GetSQLValueString($newname, "text"),
                       GetSQLValueString($_POST['status'], "int"),                       
					   GetSQLValueString($newname2, "text"),
					   GetSQLValueString($_POST['customer_destination2'], "text"),
					   GetSQLValueString($_POST['product_amount2'], "int"),
					   GetSQLValueString($_POST['po_number'], "text"),
					   GetSQLValueString($_POST['order_number'], "text"),
					   GetSQLValueString($_POST['ref_product_payment_id'], "text"),
					   GetSQLValueString($_POST['comment3'], "text"),
					   GetSQLValueString($_POST['date3'], "text"),
					   GetSQLValueString($_POST['type_product'], "text"),
					   GetSQLValueString($_POST['productsource'], "text"),	
					   GetSQLValueString($_POST['comment2'], "text"),					     
					   GetSQLValueString($_POST['rate_pricein_type3'], "text"),
					   GetSQLValueString($_POST['rate_priceout_type3'], "text"),			   
					   GetSQLValueString($_POST['id'], "int"));
					   	

	
	
/*  $updateSQL = sprintf("UPDATE shipment SET product_id=%s, customer_destination=%s, product_dateout=%s, drivermember_id=%s, product_amount=%s, rate_pricein_type1=%s, rate_priceout_type1=%s, rate_pricein_type3=%s, `comment`=%s, pictureorder=%s, status=%s WHERE id=%s",
                       GetSQLValueString($_POST['product_id'], "text"),
                       GetSQLValueString($_POST['customer_destination'], "text"),
                       GetSQLValueString($_POST['product_dateout'], "date"),
                       GetSQLValueString($_POST['drivermember_id'], "text"),
                       GetSQLValueString($_POST['product_amount'], "int"),
                       GetSQLValueString($_POST['rate_pricein_type1'], "int"),
                       GetSQLValueString($_POST['rate_priceout_type1'], "int"),
                       GetSQLValueString($_POST['rate_pricein_type3'], "int"),
                       GetSQLValueString($_POST['comment'], "text"),
                       GetSQLValueString($pictureorder, "text"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['id'], "int"));
*/
  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());
	if($Result1){
	echo "<script type='text/javascript'>";
	echo "alert('ปรับปรุงข้อมูลเรียบร้อยแล้ว');";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('ข้อมูลผิดพลาดกรุณาตรวจสอบ');";
	echo "</script>";
}


  $updateGoTo = "editshipment2.php?id=" . $row_search_shipment['id'] . "";
//	$updateGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$colname_search_shipment = "-1";
if (isset($_GET['id'])) {
  $colname_search_shipment = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_search_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_search_shipment, "int"));
$search_shipment = mysql_query($query_search_shipment, $ml) or die(mysql_error());
$row_search_shipment = mysql_fetch_assoc($search_shipment);
$totalRows_search_shipment = mysql_num_rows($search_shipment);


mysql_select_db($database_ml, $ml);
$query_show_product = "SELECT * FROM product";
$show_product = mysql_query($query_show_product, $ml) or die(mysql_error());
$row_show_product = mysql_fetch_assoc($show_product);
$totalRows_show_product = mysql_num_rows($show_product);


mysql_select_db($database_ml, $ml);
//$query_show_drivermember = "SELECT * FROM drivermember";
$query_show_drivermember = "SELECT * FROM drivermember ORDER BY driver_first_name ASC";
$show_drivermember = mysql_query($query_show_drivermember, $ml) or die(mysql_error());
$row_show_drivermember = mysql_fetch_assoc($show_drivermember);
$totalRows_show_drivermember = mysql_num_rows($show_drivermember);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<!--Script ปฏิทินเลือกวันที่  -->
<script src="jquery-1.6.min.js" type="text/javascript"></script>
<script src="jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
<link href="jquery-ui-1.8.12.custom.css" rel="stylesheet" type="text/css" />
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

</head>

<body>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center" bgcolor="#FFFF99" class="h3">ข้อมูลใบสั่งจ่ายสินค้า
            <input name="id" type="hidden" id="id" value="<?php echo $row_search_shipment['id']; ?>">
            <input name="'transaction_date" type="hidden" id="'transaction_date" value="<?php echo $row_search_shipment['transaction_date']; ?>">
            <input name="product_payment_id" type="hidden" id="product_payment_id" value="<?php echo $row_search_shipment['product_payment_id']; ?>">
            <input name="'customer_name" type="hidden" id="'customer_name" value="<?php echo $row_search_shipment['customer_name']; ?>">
            <input name="status" type="hidden" id="status" value="<?php echo $row_search_shipment['status']; ?>">
            <input name="comment" type="hidden" id="comment" value="<?php echo $row_search_shipment['comment']; ?>">
            <input name="pictureorder-ori" type="hidden" id="pictureorder-ori" value="<?php echo $row_search_shipment['pictureorder']; ?>">
            <input name="picturestatus2-ori" type="hidden" id="picturestatus2-ori" value="<?php echo $row_search_shipment['picturestatus2']; ?>">
            </td>
        </tr>
        <tr>
          <td width="50%" align="center" bgcolor="#FFCCFF" class="small">วันที่ทำรายการ&nbsp;<?php echo $row_search_shipment['transaction_date']; ?></td>
          <td width="50%" align="center" bgcolor="#FFCCFF" class="small">เลขที่ใบสั่งจ่ายสินค้า&nbsp;<?php echo $row_search_shipment['product_payment_id']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" valign="top" bgcolor="#3399FF" class="small"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3" align="center" bgcolor="#CCCCFF">ข้อมูลผู้ซื้อสินค้า</td>
              </tr>
            <tr>
              <td width="37%" bgcolor="#CCCCFF">ผู้สั่งซื้อ</td>
              <td colspan="2" bgcolor="#CCCCFF"><?php echo $row_search_shipment['customer_name']; ?></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#CCCCFF">สถานที่ส่งสินค้า</td>
              <td colspan="2" bgcolor="#CCCCFF"><textarea name="customer_destination" cols="35" rows="5" id="customer_destination"><?php echo $row_search_shipment['customer_destination']; ?></textarea></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#CCCCFF">ชื่่อย่อสถานที่ปลายทาง</td>
              <td colspan="2" bgcolor="#CCCCFF"><input name="customer_destination2" type="text" id="customer_destination2" value="<?php echo $row_search_shipment['customer_destination2']; ?>"></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#CCCCFF">Upload รูปภาพใบสั่งซื้อ<br>
                ชื่อเอกสาร : 
                <?php 
				if($row_search_shipment['pictureorder'] == "")
				{
					echo "ยังไม่มีเอกสาร";
				}
                else
				{
                	echo $row_search_shipment['pictureorder'];
                }
                ?>
             </td>                    
              <td colspan="2" valign="top" bgcolor="#CCCCFF"><input type="file" name="fileupload" id="fileupload"></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#CCCCFF">สถานะเอกสาร</td>
              <td colspan="2" bgcolor="#CCCCFF"><?php
          	switch ($row_Search_shipment['status'])
			{
				case 0 : echo  "รอพิมพ์ใบส่งสินค้า";
							break;
				case 1 : echo  "พิมพ์ใบส่งสินค้าแล้ว";
							break;
				case 2 : echo  "สินค้าส่งเรียบร้อยแล้วรอการเรียกเก็บเงิน";
							break;
				case 3 : echo  "ออกใบตั้งเบิกแล้ว";
							break;
				case 4 : echo  "ออกใบเสร็จเรียกเก็บเงินแล้ว";
							break;
				case 5 : echo  "รับเงินจากลูกค้าแล้ว";
							break;																																
				case 6 : echo  "ออกใบจ่ายค่าจ้างแก่คนขับรถส่งของแล้ว";
							break;																																
			}
		  ?></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#CCCCFF">หมายเหตุเพิ่มเติมในใบส่งสินค้า&nbsp;:</td>
              <td colspan="2" bgcolor="#CCCCFF"><textarea name="comment3" cols="35" rows="5" id="comment3"><?php echo $row_search_shipment['comment3']; ?></textarea></td>
            </tr>
            <tr>
              <td colspan="3" align="center" valign="top" bgcolor="#66CCFF">ข้อมูลราคาขาย</td>
            </tr>
            <tr>
              <td rowspan="2" align="center" valign="middle" bgcolor="#66CCFF">ประเภทที่ 1</td>
              <td width="4%" bgcolor="#66CCFF">รับ</td>
              <td width="59%" bgcolor="#66CCFF"><input name="rate_pricein_type1" type="text" id="rate_pricein_type1" value="<?php echo $row_search_shipment['rate_pricein_type1']; ?>"></td>
              </tr>
            <tr>
              <td bgcolor="#66CCFF">จ่าย</td>
              <td bgcolor="#66CCFF"><input name="rate_priceout_type1" type="text" id="rate_priceout_type1" value="<?php echo $row_search_shipment['rate_priceout_type1']; ?>"></td>
              </tr>
            <tr>
              <td rowspan="2" align="center" valign="middle" bgcolor="#66CCFF">ประเภทที่ 2</td>
              <td bgcolor="#66CCFF">รับ</td>
              <td bgcolor="#66CCFF"><input name="'rate_pricein_type2" type="text" id="'rate_pricein_type2" value="<?php echo $row_search_shipment['rate_pricein_type2']; ?>"></td>
            </tr>
            <tr>
              <td bgcolor="#66CCFF">จ่าย</td>
              <td bgcolor="#66CCFF"><input name="'rate_priceout_type2" type="text" id="'rate_priceout_type2" value="<?php echo $row_search_shipment['rate_priceout_type2']; ?>"></td>
            </tr>
            <tr>
              <td rowspan="2" align="center" valign="middle" bgcolor="#66CCFF">ประเภทที่ 3</td>
              <td bgcolor="#66CCFF">รับ</td>
              <td bgcolor="#66CCFF"><input name="rate_pricein_type3" type="text" id="rate_pricein_type3" value="<?php echo $row_search_shipment['rate_pricein_type3']; ?>"></td>
            </tr>
            <tr>
              <td bgcolor="#66CCFF">จ่าย</td>
              <td bgcolor="#66CCFF"><input name="rate_priceout_type3" type="text" id="rate_priceout_type3" value="<?php echo $row_search_shipment['rate_priceout_type3']; ?>"></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#66CCFF">สั่งซื้อโดยใช้ชื่ออื่นๆ</td>
              <td colspan="2" bgcolor="#66CCFF"><input type="text" name="comment" id="comment"></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#66CCFF">หมายเหตุเพิ่มเติม&nbsp;:</td>
              <td colspan="2" bgcolor="#66CCFF"><textarea name="comment2" cols="35" rows="5" id="comment2"><?php echo $row_search_shipment['comment2']; ?></textarea></td>
            </tr>
          </table></td>
          <td align="center" valign="top" bgcolor="#3399FF" class="small"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" bgcolor="#CCFF99">เลขที่ตั๋ว</td>
              <td align="left" bgcolor="#CCFF99"><label for="po_number"></label>
                <label for="ref_product_payment_id"></label>
                <input name="ref_product_payment_id" type="text" id="ref_product_payment_id" value="<?php echo $row_search_shipment['ref_product_payment_id']; ?>"></td>
              </tr>
            <tr>
              <td align="left" bgcolor="#CCFF99">หมายเลขใบ PO </td>
              <td align="left" bgcolor="#CCFF99"><input name="po_number" type="text" id="po_number" value="<?php echo $row_search_shipment['po_number']; ?>"></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#CCFF99">หมายเลขใบสั่งซื้อ</td>
              <td align="left" bgcolor="#CCFF99"><input name="order_number" type="text" id="order_number" value="<?php echo $row_search_shipment['order_number']; ?>"></td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#CCFF99">ข้อมูลสินค้า</td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">ชื่อสินค้า</td>
              <td bgcolor="#CCFF99"><input name="type_product" type="text" id="type_product" value="<?php echo $row_search_shipment['type_product']; ?>"></td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">จำนวน (ตัน)</td>
              <td bgcolor="#CCFF99"><input name="product_amount" type="text" id="product_amount" value="<?php echo $row_search_shipment['product_amount']; ?>"></td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">จำนวน (ถุง)</td>
              <td bgcolor="#CCFF99"><label for="product_amount2"></label>
                <input name="product_amount2" type="text" id="product_amount2" value="<?php echo $row_search_shipment['product_amount2']; ?>"></td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#CCFF99">การรับสินค้า</td>
              </tr>
            <tr>
              <td bgcolor="#CCFF99">สถานที่รับสินค้าต้นทาง </td>
              <td bgcolor="#CCFF99"><input name="productsource" type="text" id="productsource" value="<?php echo $row_search_shipment['productsource']; ?>"></td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">วันที่กำหนดให้ไปรับสินค้า</td>
              <td bgcolor="#CCFF99"><input name="product_dateout" type="text" id="date_2" value="<?php echo $row_search_shipment['product_dateout']; ?>"/></td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">วันที่ส่งสินค้าถึงปลายทาง</td>
              <td bgcolor="#CCFF99"><input name="date3" type="text" id="date_3" value="<?php echo $row_search_shipment['date3']; ?>"/></td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#CCFF99">ข้อมูลรถที่ไปรับ</td>
              </tr>
            <tr>
              <td bgcolor="#CCFF99">ชื่อคนขับ</td>
              <td bgcolor="#CCFF99">
       
             <select name="drivermember_id" id="drivermember_id">
                <?php
				do {  
				?>
                <option value="<?php echo $row_show_drivermember['driver_id']?>"<?php if (!(strcmp($row_show_drivermember['driver_id'], $row_search_shipment['drivermember_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_show_drivermember['driver_first_name']."  ".$row_show_drivermember['driver_last_name']?></option> 
                <?php
				} while ($row_show_drivermember = mysql_fetch_assoc($show_drivermember));
				  $rows = mysql_num_rows($show_drivermember);
				  if($rows > 0) {
					  mysql_data_seek($show_drivermember, 0);
					  $row_show_drivermember = mysql_fetch_assoc($show_drivermember);
				  }
				?>
              </select>

              </td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">ประเภทรถที่ไปรับ</td>
              <td bgcolor="#CCFF99"><?php echo $row_search_shipment['car_id']; ?></td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">หมายเลขทะเบียนรถ</td>
              <td bgcolor="#CCFF99"><?php echo $row_search_shipment['car_type']; ?></td>
            </tr>
            <tr>
              <td bgcolor="#CCFF99">&nbsp;</td>
              <td bgcolor="#CCFF99">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#FFFFCC"> เอกสารอ้างอิง</td>
              </tr>
            <tr>
              <td valign="top" bgcolor="#FFFFCC">Upload ใบส่งสินค้าที่ส่งแล้ว<br>
                ใบส่งสินค้าที่ส่งแล้ว : 
             </td>                    
              <td colspan="2" valign="top" bgcolor="#FFFFCC"><input type="file" name="fileupload2" id="fileupload2">
                <br>
                <?php 
				if($row_search_shipment['picturestatus2'] == "")
				{
					echo "ยังไม่มีเอกสาร";
				}
                else
				{
					echo '<a href=fileupload/'.$row_search_shipment['picturestatus2'].'>'.$row_search_shipment['picturestatus2'].'</a>';
                }
                ?></td>
            </tr>              
            <tr>
              <td bgcolor="#FFFFCC">ใบตั้งเบิก</td>
              <td bgcolor="#FFFFCC">Download</td>
            </tr>
            <tr>
              <td bgcolor="#FFFFCC">ใบเสร็จรับเงิน</td>
              <td bgcolor="#FFFFCC">Download</td>
            </tr>
            <tr>
              <td bgcolor="#FFFFCC">ใบสลิปจ่ายค่าจ้างคนขับรถ</td>
              <td bgcolor="#FFFFCC">Download</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" bgcolor="#3399FF" class="small">&nbsp;</td>
          <td align="center" bgcolor="#3399FF" class="small">         
		  </td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td colspan="2" align="center" bgcolor="#99CCFF" class="small"><input type="submit" name="button" id="button" value="บันทึกข้อมูล"></td>
        </tr>
    </table></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($search_shipment);

mysql_free_result($show_product);

mysql_free_result($show_drivermember);
?>
