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

$colname_listrecetip = "-1";
if (isset($_GET['billing_id'])) {
  $colname_listrecetip = $_GET['billing_id'];
}
mysql_select_db($database_ml, $ml);
$query_listrecetip = sprintf("SELECT * FROM receipt WHERE billing_id LIKE %s", GetSQLValueString($colname_listrecetip, "text"));
$listrecetip = mysql_query($query_listrecetip, $ml) or die(mysql_error());
$row_listrecetip = mysql_fetch_assoc($listrecetip);
$totalRows_listrecetip = mysql_num_rows($listrecetip);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
</head>
<?php
//////////// กำหนดแสดงข้อมูลวันที่ออกใบเสร็จ
//$d = $_GET["d_receipt"];
$d = str_pad($_GET["d_receipt"],2,"0",STR_PAD_LEFT);
$m = $_GET["m_receipt"];
$y = $_GET["y_receipt"];
//echo str_pad($id,3,"0",STR_PAD_LEFT);

$m_m[0]="";
$m_m[1]="มกราคม";
$m_m[2]="กุมภาพันธ์";
$m_m[3]="มีนาคม";
$m_m[4]="เมษายน";
$m_m[5]="พฤษภาคม";
$m_m[6]="มิถุนายน";
$m_m[7]="กรกฏาคม";
$m_m[8]="สิงหาคม";
$m_m[9]="กันยายน";
$m_m[10]="ตุลาคม";
$m_m[11]="พฤศจิกายน";
$m_m[12]="ธันวาคม";

$txt_date_receipt = $d."/".$m_m[$m]."/".$y;


/////////////////////////////////////////////////////////


?>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" class="h4">จัดการพิมพ์ใบเสร็จรับเงิน [วันที่ออกใบเสร็จ <?php echo $txt_date_receipt; ?>]</td>
      </tr>
      <tr>
        <td class="small">พบข้อมูลใบแจ้งหนี้จำนวน  <?php echo $totalRows_listrecetip ?>&nbsp; รายการ ดังนี้</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%" align="center" bgcolor="#FFCC99"><span class="small">วันที่ทำรายการ</span></td>
            <td width="25%" align="center" bgcolor="#FFCC99"><span class="small">ชื่อลูกค้า</span></td>
            <td width="25%" align="center" bgcolor="#FFCC99"><span class="small">จำนวนเงิน</span></td>
            <td width="25%" align="center" bgcolor="#FFCC99"><span class="small">หมายเลขใบส่งของ</span></td>
          </tr>
          <?php 
		  if($totalRows_listrecetip != 0)
		  	{
				do { 	
					$colname_showshipment = "-1";
					if (isset($row_listrecetip['shipment_id'])) {
					$colname_showshipment = $row_listrecetip['shipment_id'];
					}
					mysql_select_db($database_ml, $ml);
					$query_showshipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_showshipment, "int"));
					$showshipment = mysql_query($query_showshipment, $ml) or die(mysql_error());
					$row_showshipment = mysql_fetch_assoc($showshipment);
					$totalRows_showshipment = mysql_num_rows($showshipment);
					
					if($row_showshipment['picturestatus4'] == "")
					{
						echo 	"<tr>".
								"<td align=center' bgcolor='#FFFFCC'><span class='small'>".$row_listrecetip['transaction_date']."</span></td>".
								"<td align='left' bgcolor='#FFFFCC'><span class='small'>".$row_showshipment['customer_name']."</span></td>".
								"<td align='right' bgcolor='#FFFFCC'><span class='small'>".$row_listrecetip['total']."</span></td>".
								"<td align='right' bgcolor='#FFFFCC'><span class='small'>".$row_showshipment['product_payment_id']."</span></td>".
								"</tr>";
					}
					
							
				}while ($row_listrecetip = mysql_fetch_assoc($listrecetip));
			}
		  ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
          
          	<?php
            	if($totalRows_listrecetip != 0)
				{
					
					echo 	"<tr>".
							"<td colspan='4' align='center' class='btn-primary'>".
							"<a href='module/pdf/printreceipt.php?billing_id=".$_GET['billing_id']."&txt_date_receipt=".$txt_date_receipt."'".
                            "target='new' class='btn-secondary'>พิมพ์ใบเสร็จ</a></td>".
							"</tr>";
				}
				else
				{					
					echo	"<tr>".
							"<td colspan='4' align='center'>".
							"<a href='http://www.thelogistics.co.th/app4/index.php?pagename=receipt'>กลับ</a></td>".
							"</tr>";					
				} 
			?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($listrecetip);

mysql_free_result($showshipment);
?>
