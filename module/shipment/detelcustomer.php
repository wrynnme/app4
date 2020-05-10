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

$colname_Search_shipment = "-1";
if (isset($_GET['id'])) {
  $colname_Search_shipment = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_Search_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_Search_shipment, "int"));
$Search_shipment = mysql_query($query_Search_shipment, $ml) or die(mysql_error());
$row_Search_shipment = mysql_fetch_assoc($Search_shipment);
$totalRows_Search_shipment = mysql_num_rows($Search_shipment);

$colname_search_drivermember = "-1";
if (isset($row_Search_shipment['drivermember_id'])) {
  $colname_search_drivermember = $row_Search_shipment['drivermember_id'];
}
mysql_select_db($database_ml, $ml);
$query_search_drivermember = sprintf("SELECT * FROM drivermember WHERE driver_id = %s", GetSQLValueString($colname_search_drivermember, "int"));
$search_drivermember = mysql_query($query_search_drivermember, $ml) or die(mysql_error());
$row_search_drivermember = mysql_fetch_assoc($search_drivermember);
$totalRows_search_drivermember = mysql_num_rows($search_drivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>แสดงรายละเอียดใบสั่งจ่าย</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" align="center" bgcolor="#FFFF00" class="h3">ข้อมูลใบสั่งจ่ายสินค้า</td>
        </tr>
        <tr>
          <td width="50%" rowspan="2" align="center" bgcolor="#FFCCFF" class="small">วันที่ทำรายการ&nbsp; <?php echo $row_Search_shipment['transaction_date']; ?></td>
          <td align="left" bgcolor="#FFCCFF" class="small">เลขที่ใบสั่งจ่ายสินค้า&nbsp; <?php echo $row_Search_shipment['product_payment_id']; ?></td>
          <td align="left" bgcolor="#FFCCFF" class="small">เลขที่ตั๋ว <?php echo $row_Search_shipment['ref_product_payment_id']; ?></td>
        </tr>
        <tr>
          <td align="left" bgcolor="#FFCCFF" class="small">หมายเลขใบ PO&nbsp;&nbsp; <?php echo $row_Search_shipment['po_number']; ?></td>
          <td align="left" bgcolor="#FFCCFF" class="small">หมายเลขใบสั่งซื้อ <?php echo $row_Search_shipment['order_number']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td rowspan="2" align="center" class="small">ผู้สั่งซื้อ&nbsp; <?php echo $row_Search_shipment['customer_name']; ?></td>
          <td colspan="2" align="center" class="small">สถานที่ส่งสินค้า <?php echo $row_Search_shipment['customer_destination']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td colspan="2" align="center" class="small">ชื่อย่อสถานที่ส่งสินค้า <?php echo $row_Search_shipment['customer_destination2']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" class="small">ชื่อสินค้า <?php echo $row_Search_shipment['type_product']; ?></td>
          <td align="left" class="small">จำนวน (ตัน) <?php echo $row_Search_shipment['product_amount']; ?></td>
          <td align="left" class="small">จำนวน (ถุง) <?php echo $row_Search_shipment['product_amount2']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" class="small">สถานที่รับสินค้าต้นทาง <?php echo $row_Search_shipment['productsource']; ?></td>
          <td align="center" class="small">วันที่กำหนดให้ไปรับสินค้า <?php echo $row_Search_shipment['product_dateout']; ?></td>
          <td align="center" class="small">วันที่กำหนดส่งถึงปลายทาง <?php echo $row_Search_shipment['date3']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" class="small">ประเภทรถที่ไปรับ <?php echo $row_Search_shipment['car_type']; ?></td>
          <td width="28%" align="center" class="small">ชื่อคนขับรถ&nbsp; <?php echo $row_search_drivermember['driver_first_name']."  ".$row_search_drivermember['driver_last_name']; ?></td>
          <td width="22%" align="center" class="small">หมายเลขทะเบียนรถ&nbsp; <?php echo $row_Search_shipment['car_id']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td colspan="3" align="center" class="small">
          <?php 
		  /*
		  	if ($row_Search_shipment['pictureorder'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=fileupload/'. $row_Search_shipment['pictureorder'] .'>รูปเอกสารใบสั่งสินค้าจากผู้จ้าง</a>';
			}
			else
			{				
				echo "ไม่มีรูปเอกสารใบสั่งสินค้าจากผู้จ้าง";

			}
			*/		  
		  ?>          
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center" bgcolor="#FFFFCC" class="small">  
		  
          <table width="90%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="6" align="center" bgcolor="#CCFFFF"> สถานะเอกสาร 
			  <?php //echo $row_Search_shipment['status']; ?>
          <?php
          	switch ($row_Search_shipment['status'])
			{
				case 0 : echo  "รอพิมพ์ใบส่งสินค้า";
							break;
				case 1 : echo  "รอพิมพ์ใบตั้งเบิก";
							break;
				case 2 : echo  "รอพิมพ์ใบเสร็จรับเงิน";
							break;
				case 3 : echo  "รอพิมพ์สลิปค่าจ้าง";
							break;
				case 4 : echo  "เสร็จสิ้นกระบวนการแล้ว";
							break;	
				case 9 : echo  "<strong><font color=FF0000>เอกสารนี้ถููกยกเลิกการทำรายการ</font></strong>";
							break;																																							
			}
		  ?></td>
              </tr>
            <tr>
              <td width="15%" align="center" valign="top" bgcolor="#FFFF33">รูปใบสั่งสินค้า</td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFF33">รูปตั๋วสินค้า</td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFF33">รูปใบส่งสินค้า</td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFF33">ใบตั้งเบิก</td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFF33">ใบเสร็จรับเงิน</td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFF33"><p>ใบสลิปค่าจ้างผู้ส่งของ</p></td>
              </tr>
            <tr>
              <td width="15%" align="center" bgcolor="#FFFFFF">
              <?php
              		if ($row_Search_shipment['pictureorder'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<img src=images/ok.png width=50 height=50>';
			}
			else
			{				
				echo '<img src=images/wrong.png width=50 height=50>';

			}
			  ?>
              </td>
              <td width="15%" align="center" bgcolor="#FFFFFF"><?php
              		if ($row_Search_shipment['picturestatus2'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<img src=images/ok.png width=50 height=50>';
			}
			else
			{				
				echo '<img src=images/wrong.png width=50 height=50>';

			}
			  ?>
              </td>
              <td width="15%" align="center" bgcolor="#FFFFFF"><?php
              		if ($row_Search_shipment['picturestatus1'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<img src=images/ok.png width=50 height=50>';
			}
			else
			{				
				echo '<img src=images/wrong.png width=50 height=50>';

			}
			  ?></td>
              <td width="15%" align="center" bgcolor="#FFFFFF"><?php
              		if ($row_Search_shipment['picturestatus3'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<img src=images/ok.png width=50 height=50>';
			}
			else
			{				
				echo '<img src=images/wrong.png width=50 height=50>';

			}
			  ?>
              </td>
              <td width="15%" align="center" bgcolor="#FFFFFF"><?php
              		if ($row_Search_shipment['picturestatus4'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<img src=images/ok.png width=50 height=50>';
			}
			else
			{				
				echo '<img src=images/wrong.png width=50 height=50>';

			}
			  ?>
              </td>
              <td width="15%" align="center" bgcolor="#FFFFFF"><?php
              		if ($row_Search_shipment['picturestatus5'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<img src=images/ok.png width=50 height=50>';
			}
			else
			{				
				echo '<img src=images/wrong.png width=50 height=50>';

			}
			  ?>
              ;</td>
              </tr>
            <tr>
              <td width="15%" align="center" valign="top" bgcolor="#FFFFFF"> <?php 
		  	if ($row_Search_shipment['pictureorder'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=fileupload/'. $row_Search_shipment['pictureorder'] .'>ดูเอกสาร</a>';
			}
			else
			{				
				echo "รอการปรับปรุงข้อมูล";

			}		  
		  ?></td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFFFF"> <?php 
		  	if ($row_Search_shipment['picturestatus2'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=fileupload/'. $row_Search_shipment['picturestatus2'] .'>ดูเอกสาร</a>';
			}
			else
			{				
				echo "รอการปรับปรุงข้อมูล";

			}		  
		  ?></td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFFFF"><?php 
		  	if ($row_Search_shipment['picturestatus1'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=fileupload/'. $row_Search_shipment['picturestatus1'] .'>ดูเอกสาร</a>';
			}
			else
			{				
				echo "รอการปรับปรุงข้อมูล";

			}		  
		  ?></td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFFFF"> <?php 
		  	if ($row_Search_shipment['picturestatus3'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=fileupload/'. $row_Search_shipment['picturestatus3'] .'>ดูเอกสาร</a>';
			}
			else
			{				
				echo "รอการปรับปรุงข้อมูล";

			}		  
		  ?></td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFFFF"> <?php 
		  	if ($row_Search_shipment['picturestatus4'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=fileupload/'. $row_Search_shipment['picturestatus4'] .'>ดูเอกสาร</a>';
			}
			else
			{				
				echo "รอการปรับปรุงข้อมูล";

			}		  
		  ?></td>
              <td width="15%" align="center" valign="top" bgcolor="#FFFFFF"> <?php 
		  	if ($row_Search_shipment['picturestatus5'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=fileupload/'. $row_Search_shipment['picturestatus5'] .'>ดูเอกสาร</a>';
			}
			else
			{				
				echo "รอการปรับปรุงข้อมูล";

			}		  
		  ?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3" align="center" bgcolor="#FFFFCC" class="small"><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="8" align="center" bgcolor="#FFFFFF">ข้อมูลการส่งสินค้า&nbsp;
              <?php
              	if ($row_Search_shipment['comment'] <> "")
					{
						 echo "จัดส่งสินค้าโดยผู้ว่าจ้างภายนอก" . "  " .$row_Search_shipment['comment'];
					}
              ?>
              </td>
              </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#FFFFCC">ค่าจ้างขนส่ง</td>
              <td colspan="3" align="center" bgcolor="#CCCCFF">กรณีจ้างเหมาเพิ่มเติม<br>
                (ย้ายจุด / เกินระยะทาง)</td>
              <td width="10%" align="center" bgcolor="#FFFFFF"><a href="editshipment.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-info">              
              	<ion-icon name="settings"></ion-icon>แก้ไขเอกสาร</a></td>
              <td width="10%" align="center" bgcolor="#FFFFFF"><!--<a href="editstatusshipment.php?id=<?php //echo $_GET['id']; ?>" class="btn btn-outline-info">              
              	<ion-icon name="settings"></ion-icon>เปลี่ยนสถานะเอกสาร</a> --></td>
              <td width="10%" align="center" bgcolor="#FFFFFF"><a href="deleteshipment.php?id=<?php echo $_GET['id']; ?>&status=9" class="btn btn-outline-info" onclick= "return confirm('ต้องการยกเลิกเอกสาร จริงหรือไม่ ?')">              
              	<ion-icon name="remove-circle-outline"></ion-icon>ยกเลิกเอกสาร</a></td>
              </tr>
            <tr>
              <td width="20%" align="center" bgcolor="#FFFFCC">&nbsp;ราคาตกลงขายให้ลูกค้า</td>
              <td width="20%" align="center" bgcolor="#FFFFCC">ราคาจ้างผู้ขับรถส่งสินค้า</td>
              <td width="10%" align="center" bgcolor="#999999">รายละเอียด</td>
              <td width="10%" align="center" bgcolor="#999999">ราคาตกลงกับลูกค้า</td>
              <td width="10%" align="center" bgcolor="#999999">ราคาจ้างกับผู้ส่งสินค้า</td>
              <td width="25%" colspan="3" align="center" bgcolor="#FFFFFF">
              	<!--<a href="../pdf/printshipment1.php?id=<?php //echo $row_Search_shipment['id']; ?>" target="new" class="btn btn-outline-info">
              	<ion-icon name="print"></ion-icon> พิมพ์เอกสาร</a> -->
              	<a href="status.php?id=<?php echo $row_Search_shipment['id']; ?>&product_payment_id=<?php echo $row_Search_shipment['product_payment_id']; ?>" target="new" class="btn btn-outline-info">
              	<ion-icon name="print"></ion-icon> พิมพ์เอกสาร</a>

              </td>
              </tr>
            <tr>
              <td width="20%" align="center" bgcolor="#FFFFCC"><?php echo $row_Search_shipment['rate_pricein_type1']; ?></td>
              <td width="20%" align="center" bgcolor="#FFFFCC"><?php echo $row_Search_shipment['rate_priceout_type1']; ?></td>
              <td width="10%" align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['comment2']; ?></td>
              <td width="10%" align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_pricein_type3']; ?></td>
              <td width="10%" align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_priceout_type3']; ?></td>
              <td colspan="3" align="center" bgcolor="#FFFFFF">
              	<a href="closewindows.php" class="btn btn-outline-dark">
                <ion-icon name="close-circle"></ion-icon> ปิดหน้าต่าง</a>                
              </td>                
              </tr>
            <tr>
              <td align="center" bgcolor="#FFFFCC">&nbsp;</td>
              <td align="center" bgcolor="#FFFFCC">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" bgcolor="#FFFFCC">&nbsp;</td>
              <td align="center" bgcolor="#FFFFCC">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Search_shipment);

mysql_free_result($search_drivermember);
?>

