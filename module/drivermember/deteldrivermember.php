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

$colname_detel_drivermember = "-1";
if (isset($_GET['driver_id'])) {
  $colname_detel_drivermember = $_GET['driver_id'];
}
mysql_select_db($database_ml, $ml);
$query_detel_drivermember = sprintf("SELECT * FROM drivermember WHERE driver_id = %s", GetSQLValueString($colname_detel_drivermember, "int"));
$detel_drivermember = mysql_query($query_detel_drivermember, $ml) or die(mysql_error());
$row_detel_drivermember = mysql_fetch_assoc($detel_drivermember);
$totalRows_detel_drivermember = mysql_num_rows($detel_drivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>แสดงข้อมูลลูกค้า</title>
<link rel= "stylesheet" href="../../../../bootstrap/css/bootstrap.css">
</head>

<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center" bgcolor="#FF9900" class="h3">ข้อมูลผู้ขับรถส่งสินค้า</td>
        </tr>
        <tr>
          <td width="200" bgcolor="#FFFFCC"><span class="small">ชื่อคนขับรถ</span></td>
          <td width="400" class="small">&nbsp;<?php echo $row_detel_drivermember['driver_first_name']; ?>&nbsp; <?php echo $row_detel_drivermember['driver_last_name']; ?></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#FFFFCC"><span class="small">ที่อยู่</span></td>
          <td class="small">เลขที่ &nbsp;<?php echo $row_detel_drivermember['address_1']; ?><br>
            ถนน <?php echo $row_detel_drivermember['address_2']; ?><br>
            ตำบล <?php echo $row_detel_drivermember['address_3']; ?><br>            
            อำเภอ <?php echo $row_detel_drivermember['adress_4']; ?><br>            
            จังหวัด <?php echo $row_detel_drivermember['address_5']; ?><br>            
          รหัสไปรษณีย์ <?php echo $row_detel_drivermember['postcode']; ?><br></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">หมายเลขโทรศัพท์</span></td>
          <td class="small"><?php echo $row_detel_drivermember['driver_tel']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">หมายเลขบัญชีเพื่อโอนเงินค่าจ้าง</span></td>
          <td class="small"><?php echo $row_detel_drivermember['driver_bookbank_name']; ?>&nbsp;สาขา  <?php echo $row_detel_drivermember['driver_bookbank_branch']; ?>&nbsp;  เลขบัญชี <?php echo $row_detel_drivermember['driver_bookbank_id']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">ประเภทรถ / เลขทะเบียนรถ</span></td>
          <td class="small"><?php echo $row_detel_drivermember['driver_car_type']; ?>&nbsp;/ <?php echo $row_detel_drivermember['driver_car_id']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC">หมายเหตุคนขับรถ</td>
          <td class="small"><a href="http://<?php echo $row_detel_drivermember['driver_comment']; ?>" target="drivermember"><?php echo $row_detel_drivermember['driver_comment']; ?></a></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC">เอกสารคนขับรถ</td>
          <td class="small">
		  <?php
//          echo $row_detel_drivermember['driver_doc'];
		  if ($row_detel_drivermember['driver_doc'] <>"")
			  {
					echo '<a href="fileupload/'.$row_detel_drivermember['driver_doc'].'">ดูเอกสาร</a>';
			  }
		  else
			  	{
					echo 'รอการปรับปรุงข้อมูล';
				}		  
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
mysql_free_result($detel_drivermember);
?>
