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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {	
$filename = "driver_".date ("dmYHis");
//Upload files	
	include ("uploadfile.php");	
//เสร็จการ Upload File
	
	
  $insertSQL = sprintf("INSERT INTO drivermember (driver_first_name, driver_last_name, driver_id_card, address_1, address_2, address_3, adress_4, address_5, postcode, driver_tel, driver_bookbank_name, driver_bookbank_branch, driver_bookbank_id, driver_car_id, driver_car_type, driver_comment, driver_doc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['driver_first_name'], "text"),
                       GetSQLValueString($_POST['driver_last_name'], "text"),
                       GetSQLValueString($_POST['driver_id_card'], "text"),
                       GetSQLValueString($_POST['address_1'], "text"),
                       GetSQLValueString($_POST['address_2'], "text"),
                       GetSQLValueString($_POST['address_3'], "text"),
                       GetSQLValueString($_POST['adress_4'], "text"),
                       GetSQLValueString($_POST['address_5'], "text"),
                       GetSQLValueString($_POST['postcode'], "text"),
                       GetSQLValueString($_POST['driver_tel'], "text"),
                       GetSQLValueString($_POST['driver_bookbank_name'], "text"),
                       GetSQLValueString($_POST['driver_bookbank_branch'], "text"),
                       GetSQLValueString($_POST['driver_bookbank_id'], "text"),
                       GetSQLValueString($_POST['driver_car_id'], "text"),
                       GetSQLValueString($_POST['driver_car_type'], "text"),
					   GetSQLValueString($_POST['driver_comment'], "text"),
					   GetSQLValueString($newname, "text"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($insertSQL, $ml) or die(mysql_error());

//  $insertGoTo = "listdrivermember.php";
  $insertGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_ml, $ml);
$query_adddrivermember = "SELECT * FROM drivermember";
$adddrivermember = mysql_query($query_adddrivermember, $ml) or die(mysql_error());
$row_adddrivermember = mysql_fetch_assoc($adddrivermember);
$totalRows_adddrivermember = mysql_num_rows($adddrivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>บันทึกข้อมูลลูกค้าใหม่</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<form method="post" name="form2" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">เพิ่มข้อมูลผู้ขับรถส่งสินค้า</td>
    </tr>
    <tr>
      <td><table width="600" align="center">
        <tr valign="baseline">
          <td width="168" align="right" nowrap bgcolor="#FFFFCC"><span class="small">ชื่อ *:</span></td>
          <td width="235" bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_first_name" value="" size="32">
          </span></td>
          <td width="181" bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">นามสกุล *:</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_last_name" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขบัตรประชาชน *:</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_id_card" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">ตัวอย่าง 1234567890123</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ที่อยู่ :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_1" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ถนน :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_2" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ตำบล / แขวง :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_3" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">อำเภอ / เขต :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="adress_4" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">จังหวัด :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_5" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">รหัสไปรษณีย์ :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="postcode" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขโทรศัพท์ติดต่อ *:</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_tel" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">ตัวอย่าง 0879999999</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ชื่อธนาคาร :</span></td>
          <td bgcolor="#FFFFCC"><label for="driver_bookbank_name"></label>
            <select name="driver_bookbank_name" class="small" id="driver_bookbank_name">
              <option value="ธ.กรุงเทพ">ธ.กรุงเทพ</option>
              <option value="ธ.กรุงไทย">ธ.กรุงไทย</option>
              <option value="ธ.กรุงศรีอยุธยา">ธ.กรุงศรีอยุธยา</option>
              <option value="ธ.กสิกรไทย">ธ.กสิกรไทย</option>
              <option value="ธ. เกียรตินาคิน">ธ. เกียรตินาคิน</option>
              <option value="ธ. ซีไอเอ็มบี ไทย">ธ. ซีไอเอ็มบี ไทย</option>
              <option value="ธ. ทหารไทย">ธ. ทหารไทย</option>
              <option value="ธ. ทิสโก้ ">ธ. ทิสโก้ </option>
              <option value="ธ. ไทยพาณิชย์">ธ. ไทยพาณิชย์</option>
              <option value="ธ. ธนชาต">ธ. ธนชาต</option>
              <option value="ธ. ยูโอบี">ธ. ยูโอบี</option>
              <option value="ธ. แลนด์ แอนด์ เฮ้าส์">ธ. แลนด์ แอนด์ เฮ้าส์</option>
              <option value="ธ. ไอซีบีซี (ไทย)">ธ. ไอซีบีซี (ไทย)</option>
            </select></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">สาขา :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_bookbank_branch" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขบัญชี :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_bookbank_id" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">ตัวอย่าง 1234567890</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขทะเบียนรถ :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_car_id" value="" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ประเภทรถ :</span></td>
          <td bgcolor="#FFFFCC"><select name="driver_car_type" class="small" id="driver_car_type">
            <option value="รถบรรทุก 4 ล้อ">รถบรรทุก 4 ล้อ</option>
            <option value="รถบรรทุก 6 ล้อ">รถบรรทุก 6 ล้อ</option>
            <option value="รถบรรทุก 10 ล้อ">รถบรรทุก 10 ล้อ</option>
            <option value="รถพ่วง">รถพ่วง</option>
          </select></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap bgcolor="#FFFFCC">หมายเหตุคนขับรถ :</td>
          <td bgcolor="#FFFFCC"><textarea name="driver_comment" cols="35" rows="5" id="driver_comment"></textarea></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC">Upload เอกสารคนขับรถ :</td>
          <td bgcolor="#FFFFCC"><label for="driver_car_type"><span class="small">
            <input name="fileupload" type="file" id="fileupload" size="25" maxlength="255">
          </span></label></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td align="center"><input type="submit" class="small" value="บันทึกข้อมูล"></td>
          <td class="small">(ุ เครื่องหมาย * จะต้องกรอกให้ครบ)</td>
        </tr>
      </table>
      <br>
      &nbsp;</td>
    </tr>
  </table>
  <br>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($adddrivermember);
?>
