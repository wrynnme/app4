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
          <td colspan="2" align="center" bgcolor="#FFFF00" class="h3">ข้อมูลใบสั่งจ่ายสินค้า</td>
        </tr>
        <tr>
          <td width="50%" align="center" bgcolor="#FFCCFF" class="small">วันที่ทำรายการ&nbsp; <?php echo $row_Search_shipment['transaction_date']; ?></td>
          <td width="50%" align="center" bgcolor="#FFCCFF" class="small">เลขที่ใบสั่งจ่ายสินค้า&nbsp; <?php echo $row_Search_shipment['product_payment_id']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" class="small">ผู้สั่งซื้อ&nbsp; <?php echo $row_Search_shipment['customer_name']; ?></td>
          <td align="center" class="small">สถานที่ส่งสินค้า <?php echo $row_Search_shipment['customer_destination']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" class="small">ชื่อสินค้า <?php echo $row_Search_shipment['type_product']; ?></td>
          <td align="center" class="small">จำนวน (ตัน) <?php echo $row_Search_shipment['product_amount']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" class="small">สถานที่รับสินค้าต้นทาง <?php echo $row_Search_shipment['productsource']; ?></td>
          <td align="center" class="small">วันที่กำหนดให้ไปรับสินค้า <?php echo $row_Search_shipment['product_dateout']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td align="center" class="small">ประเภทรถที่ไปรับ <?php echo $row_Search_shipment['car_type']; ?></td>
          <td align="center" class="small">หมายเลขทะเบียนรถ&nbsp; <?php echo $row_Search_shipment['car_id']; ?></td>
        </tr>
        <tr bgcolor="#FFCCFF">
          <td colspan="2" align="center" class="small">
          <?php 
		  	if ($row_Search_shipment['pictureorder'] <> "")
			{
				//echo $row_Search_shipment['imagejobnumber'];
				echo '<a href=../../uploads/step1/'. $row_Search_shipment['pictureorder'] .'>รูปเอกสารใบสั่งสินค้าจากผู้จ้าง</a>';
			}
			else
			{				
				echo "ไม่มีรูปเอกสารใบสั่งสินค้าจากผู้จ้าง";

			}		  
		  ?>          
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#FFFFCC" class="small">สถานะเอกสาร   
		  <?php //echo $row_Search_shipment['status']; ?>
          <?php
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
		  ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#FFFFCC" class="small"><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="7" align="center" bgcolor="#FFFFFF">ข้อมูลการขาย&nbsp;
              <?php
              	if ($row_Search_shipment['comment'] <> "")
					{
						 echo "จัดส่งสินค้าโดยผู้ว่าจ้างภายนอก" . "  " .$row_Search_shipment['comment'];
					}
              ?>
              </td>
              </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#CCCCFF">&nbsp;</td>
              <td colspan="2" align="center" bgcolor="#CCCCFF">เหมาเที่ยว</td>
              <td colspan="3" align="center" bgcolor="#CCCCFF">&nbsp;</td>
              </tr>
            <tr>
              <td width="15%" align="center" bgcolor="#999999">&nbsp;รับ</td>
              <td width="15%" align="center" bgcolor="#999999">จ่าย</td>
              <td width="15%" align="center" bgcolor="#999999">รับ</td>
              <td width="15%" align="center" bgcolor="#999999">จ่าย</td>
              <td width="15%" align="center" bgcolor="#999999">รับ</td>
              <td width="15%" align="center" bgcolor="#999999">จ่าย</td>
              <td width="10%" align="center" bgcolor="#FFFFFF">
              	<a href="#" class="btn btn-outline-info">
              	<ion-icon name="print"></ion-icon> พิมพ์เอกสาร</a>
              </td>
              </tr>
            <tr>
              <td align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_pricein_type1']; ?></td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_priceout_type1']; ?></td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_pricein_type2']; ?></td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_priceout_type2']; ?></td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_pricein_type3']; ?></td>
              <td align="center" bgcolor="#FFFFFF"><?php echo $row_Search_shipment['rate_priceout_type3']; ?></td>
              <td align="center" bgcolor="#FFFFFF">
              	<a href="closewindows.php" class="btn btn-outline-dark">
                <ion-icon name="close-circle"></ion-icon> ปิดหน้าต่าง</a>                
              </td>                
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
?>

