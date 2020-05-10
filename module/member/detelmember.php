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

$colname_detel_member = "-1";
if (isset($_GET['id'])) {
  $colname_detel_member = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_detel_member = sprintf("SELECT * FROM member WHERE id = %s", GetSQLValueString($colname_detel_member, "int"));
$detel_member = mysql_query($query_detel_member, $ml) or die(mysql_error());
$row_detel_member = mysql_fetch_assoc($detel_member);
$totalRows_detel_member = mysql_num_rows($detel_member);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>แสดงข้อมูลลูกค้า</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center" bgcolor="#FF9900" class="h3">ข้อมูลลูกค้า</td>
        </tr>
        <tr>
          <td width="200" bgcolor="#FFFFCC"><span class="small">ชื่อพนักงาน</span></td>
          <td width="400" class="small"><?php echo $row_detel_member['firstname']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_detel_member['lastname']; ?></td>
        </tr>
        <tr>
          <td valign="middle" bgcolor="#FFFFCC" class="small">หมายเลขบัตรประจำตัวประชาชน</td>
          <td class="small"><?php echo $row_detel_member['username']; ?><br></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">หมายเลขโทรศัพท์ติดต่อ</span></td>
          <td class="small"><?php echo $row_detel_member['telephone']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">ชื่อผู้ใช้งานระบบ</span></td>
          <td class="small"><?php echo $row_detel_member['username']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC"><span class="small">รหัสผ่าน</span></td>
          <td class="small"><?php echo $row_detel_member['password']; ?></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC" class="small">สถานะการใช้งานระบบ</td>
          <td class="small">
		   <?php 
			switch($row_detel_member['status'])
			{
				case 0 : $statustype = "ผู้ดูแลระบบ"; break;
				case 1 : $statustype = "เจ้าหน้าที่บัญชี"; break;
				case 2 : $statustype = "เจ้าหน้าที่คีย์ข้อมูล"; break;													
			}
		?>
		  
		  <?php echo $statustype; ?></td>
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
mysql_free_result($detel_member);
?>
