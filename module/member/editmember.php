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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE member SET username=%s, password=%s, firstname=%s, lastname=%s, telephone=%s, status=%s WHERE id=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());

  $updateGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


$colname_edit_member = "-1";
if (isset($_GET['id'])) {
  $colname_edit_member = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_edit_member = sprintf("SELECT * FROM member WHERE id = %s", GetSQLValueString($colname_edit_member, "int"));
$edit_member = mysql_query($query_edit_member, $ml) or die(mysql_error());
$row_edit_member = mysql_fetch_assoc($edit_member);
$totalRows_edit_member = mysql_num_rows($edit_member);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>บันทึกข้อมูลลูกค้าใหม่</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" enctype="multipart/form-data">
<input name="id" type="hidden">
<input name="pictureorder-ori" type="hidden" id="pictureorder-ori">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">แก้ไขข้อมูลพนักงาน</td>
    </tr>
    <tr>
      <td valign="top"><table width="600" align="center">
        <tr valign="baseline">
          <td width="201" align="right" nowrap bgcolor="#FFFFCC"><span class="small">ชื่อ:</span></td>
          <td width="198" bgcolor="#FFFFCC">            <span class="small">
            <input name="firstname" type="text" id="firstname" value="<?php echo $row_edit_member['firstname']; ?>" size="32">            
            </span></td>
          <td width="185" bgcolor="#FFFFCC"><span class="small">ชื่อบริษัท / ชื่อบุคคล</span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">นามสกุล:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input name="lastname" type="text" id="lastname" value="<?php echo $row_edit_member['lastname']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">เลขบัตรประจำตัวประชาชน:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input name="username" type="text" id="username" value="<?php echo $row_edit_member['username']; ?>" size="32" readonly>            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">เบอร์โทรศัพท์:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input name="telephone" type="text" id="telephone" value="<?php echo $row_edit_member['telephone']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ชื่อเข้าใช้งานระบบ:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input name="username" type="text" id="username" value="<?php echo $row_edit_member['username']; ?>" size="32" readonly>            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">รหัสผ่าน:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input name="password" type="text" id="password" value="<?php echo $row_edit_member['password']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">สถานะผู้ใช้งานระบบ:</span></td>
          <td bgcolor="#FFFFCC"><select name="status" id="status" class="small">
            <option value="0" <?php if (!(strcmp(0, $row_edit_member['status']))) {echo "selected=\"selected\"";} ?>>ผู้ดูแลระบบ</option>
            <option value="1" <?php if (!(strcmp(1, $row_edit_member['status']))) {echo "selected=\"selected\"";} ?>>เจ้าหน้าที่บัญชี</option>
            <option value="2" <?php if (!(strcmp(2, $row_edit_member['status']))) {echo "selected=\"selected\"";} ?>>เจ้าหน้าที่คีย์ข้อมูล</option>
          </select></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><input name="id" type="hidden" id="id" value="<?php echo $row_edit_member['id']; ?>"></td>
          <td>            <span class="small">
            <input type="submit" value="บันทึกข้อมูล">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
    </table></td>
    </tr>
  </table>
  <br>
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_member);
?>
