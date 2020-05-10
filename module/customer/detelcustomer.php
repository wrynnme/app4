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

$colname_detel_customer = "-1";
if (isset($_GET['id'])) {
  $colname_detel_customer = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_detel_customer = sprintf("SELECT * FROM customer WHERE id = %s", GetSQLValueString($colname_detel_customer, "int"));
$detel_customer = mysql_query($query_detel_customer, $ml) or die(mysql_error());
$row_detel_customer = mysql_fetch_assoc($detel_customer);
$totalRows_detel_customer = mysql_num_rows($detel_customer);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>แสดงข้อมูลลูกค้า</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center" bgcolor="#FF9900" class="h3">ข้อมูลลูกค้า</td>
        </tr>
        <tr>
          <td width="200" bgcolor="#FFFFCC"><span class="small">ชื่อลูกค้า</span></td>
          <td width="400" class="small"><?php echo $row_detel_customer['name']; ?></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#FFFFCC"><span class="small">ที่อยู่</span></td>
          <td class="small">เลขที่ <?php echo $row_detel_customer['address1']; ?>&nbsp;<br>
            ถนน <?php echo $row_detel_customer['address2']; ?><br>
            ตำบล <?php echo $row_detel_customer['address3']; ?><br>            
            อำเภอ <?php echo $row_detel_customer['address4']; ?><br>            
            จังหวัด <?php echo $row_detel_customer['address5']; ?><br>            
            รหัสไปรษณีย์ <?php echo $row_detel_customer['postcode']; ?><br></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">หมายเลขโทรศัพท์</span></td>
          <td class="small"><?php echo $row_detel_customer['telephone']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">หมายเลขโทรสาร</span></td>
          <td class="small"><?php echo $row_detel_customer['faxnumber']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">หมายเลขประจำตัวผู้เสียภาษี</span></td>
          <td class="small"><?php echo $row_detel_customer['tax_customer_id']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">หมายเหตุลูกค้า</span></td>
          <td class="small"><?php echo $row_detel_customer['comment_costomer']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">เอกสารประกอบ</span></td>
          <td class="small">
          <?php 
				//echo $row_detel_customer['customer_doc'];
		  //แสดงข้อมูลเอกสาร Upload ถ้ามีมีจะขึ้นข้อความว่า "รอการอัพโหลดเอกสาร" ถ้ามีข้อมูล จะแสดง Link ดูเอกสาร
		 	if ($row_detel_customer['customer_doc'] <> "")
				{
					echo '<a href="fileupload/'.$row_detel_customer['customer_doc'].'" target="new">ดูเอกสาร</a>';
				}
			else
				{
					echo 'รอการอัพโหลดเอกสาร';
				}		 
		  //##################################################################################
		  ?>          
          </td>
        </tr>                
        <tr>
          <td colspan="2" align="center" bgcolor="#FF9900" class="small"><a href="closewindows.html">ปิดหน้าต่าง</a></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($detel_customer);
?>
