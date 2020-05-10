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

mysql_select_db($database_ml, $ml);
$query_listdrivermember = "SELECT * FROM drivermember";
$listdrivermember = mysql_query($query_listdrivermember, $ml) or die(mysql_error());
$row_listdrivermember = mysql_fetch_assoc($listdrivermember);
$totalRows_listdrivermember = mysql_num_rows($listdrivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>หน้าจัดการข้อมูลลูกค้า</title>
<link rel= "stylesheet" href="../../../../bootstrap/css/bootstrap.css">
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<br>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5" align="center" bgcolor="#FF9900" class="h3">ข้อมูลผู้ขับรถขนส่งของ</td>
        <td width="132" colspan="3" align="center" valign="middle" bgcolor="#FFCC66" class="small"><p><a href="index.php?pagename=listdrivermember">Reload</a></p></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#66FFFF"><span class="small">ลำดับที่</span></td>
        <td width="20%" align="center" bgcolor="#66FFFF"><span class="small">ชื่อผู้ขับรถ</span></td>
        <td width="20%" align="center" bgcolor="#66FFFF"><span class="small">โทรศัพท์</span></td>
        <td width="20%" align="center" bgcolor="#66FFFF"><span class="small">หมายเลขบัตรประชาชน</span></td>
        <td width="20%" align="center" bgcolor="#66FFFF"><span class="small">หมายเลขทะเบียนรถ / ประเภทรถ</span></td>
        <td colspan="3" align="center" bgcolor="#FFCC66"><span class="small"><a href="module/drivermember/adddrivermember.php">เพิ่มข้อมูลใหม่</a></span></td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>
        
        
          <?php do { ?>
          <?php $count_numner = $count_numner+1 ;?>
         	<tr>
            <td width="5%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $count_numner; ?></td>
            <td width="400" align="left" bgcolor="#FFFFFF" class="small" onClick="MM_openBrWindow('deteldrivermember.php?driver_id=<?php echo $row_listdrivermember['driver_id']; ?>','','width=700,height=400')"><?php echo $row_listdrivermember['driver_first_name']; ?>&nbsp; <?php echo $row_listdrivermember['driver_last_name']; ?></td>
            <td align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listdrivermember['driver_tel']; ?></td>
            <td align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listdrivermember['driver_id_card']; ?></td>
            <td width="200" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listdrivermember['driver_car_id']; ?>&nbsp;/ <?php echo $row_listdrivermember['driver_car_type']; ?></td>
            <td width="5%" align="center" bgcolor="#FFFFFF"><a href="module/drivermember/deteldrivermember.php?driver_id=<?php echo $row_listdrivermember['driver_id']; ?>" target="new">ดูข้อมูล</a></td>
            <td width="5%" align="center" bgcolor="#FFFFFF"><span class="small"><a href="module/drivermember/editdrivermember.php?driver_id=<?php echo $row_listdrivermember['driver_id']; ?>" target="new">แก้ไข</a></span></td>
            <td width="5%" align="center" bgcolor="#FFFFFF"><span class="small"><a href="module/drivermember/deletedrivermember.php?driver_id=<?php echo $row_listdrivermember['driver_id']; ?>" target="new" onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')">ลบข้อมูล</a></span></td>  
	        </tr>
		<?php } while ($row_listdrivermember = mysql_fetch_assoc($listdrivermember)); ?>
    </table>
    <a href="../../index.php"></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($listdrivermember);

//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
?>
