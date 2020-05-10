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
$query_list_customer = "SELECT * FROM member";
$list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
$row_list_customer = mysql_fetch_assoc($list_customer);
$totalRows_list_customer = mysql_num_rows($list_customer);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>หน้าจัดการข้อมูลลูกค้า</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
</head>

<body>
<br>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="6" align="center" bgcolor="#FF9900" class="h3" width="85%">ข้อมูลพนักงาน</td>
        <td colspan="3" align="center" valign="middle" bgcolor="#FFCC66" class="small" width="15%"><p><a href="index.php?pagename=listmember">Reload</a></p></td>
      </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#66FFFF"><span class="small">ลำดับที่</span></td>
        <td width="40%" colspan="2" align="center" bgcolor="#66FFFF"><span class="small">ชื่อ-นามสกุล เจ้าหน้าที่</span></td>
        <td width="10%" align="center" bgcolor="#66FFFF"><span class="small">โทรศัพท์</span></td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">ชื่อเข้าระบบ</td>
        <td width="15%" align="center" bgcolor="#66FFFF"><span class="small">ประเภทผู้ใช้งาน</span></td>
        <td colspan="15%" align="center" bgcolor="#FFCC66"><span class="small"><a href="module/member/addmember.php" target="new">เพิ่มข้อมูลใหม่</a></span></td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>      
        <?php do { ?>
        <?php $count_numner = $count_numner+1 ;?>
        <?php 
			switch($row_list_customer['status'])
			{
				case 0 : $statustype = "ผู้ดูแลระบบ"; break;
				case 1 : $statustype = "เจ้าหน้าที่บัญชี"; break;
				case 2 : $statustype = "เจ้าหน้าที่คีย์ข้อมูล"; break;													
			}
		?>
        <tr>        	
          <td width="5%" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $count_numner; ?></span></td>
          <td width="20%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_list_customer['firstname']; ?></td>
          <td width="20%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_list_customer['lastname']; ?></td>
          <td width="10%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_list_customer['telephone']; ?></td>
          <td width="15%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_list_customer['username']; ?></td>          
          <td width="15%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $statustype; ?></td>
          <td width="5%" align="center" bgcolor="#FFFFFF" class="small"><a href="module/member/detelmember.php?id=<?php echo $row_list_customer['id']; ?>" target="new"><ion-icon name="paper"></ion-icon></a></td>
          <td width="5%" align="center" bgcolor="#FFFFFF"><a href="module/member/editmember.php?id=<?php echo $row_list_customer['id']; ?>" target="new" class="small"><ion-icon name="settings"></ion-icon></a></td>
          <td width="5%" align="center" bgcolor="#FFFFFF"><span class="small"><a href="module/member/deletemember.php?id=<?php echo $row_list_customer['id']; ?>" onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"><ion-icon name="remove-circle-outline"></ion-icon></a></span></td>
 	   </tr>       
	   <?php } while ($row_list_customer = mysql_fetch_assoc($list_customer)); ?>
  </table>
    <a href="../../index.php"></a></td>
  </tr>
</table>
</body>
</html>
<?php
//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
mysql_free_result($list_customer);
?>
