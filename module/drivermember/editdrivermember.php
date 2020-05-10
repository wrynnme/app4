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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
$filename = "driver_".date ("dmYHis");
	
include "uploadfile.php";
	
	if ($newname == "")
	{
		$newname = $_POST["pictureorder-ori"];
	}	
	
  $updateSQL = sprintf("UPDATE drivermember SET driver_first_name=%s, driver_last_name=%s, driver_id_card=%s, address_1=%s, address_2=%s, address_3=%s, adress_4=%s, address_5=%s, postcode=%s, driver_tel=%s, driver_bookbank_name=%s, driver_bookbank_branch=%s, driver_bookbank_id=%s, driver_car_id=%s, driver_car_type=%s, driver_comment=%s, driver_doc=%s WHERE driver_id=%s",
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
					   GetSQLValueString($newname, "text"),
                       GetSQLValueString($_POST['driver_id'], "int"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());

//  $updateGoTo = "listdrivermember.php";
//  $updateGoTo = "../../index.php?pagename=listdrivermember";  
  $updateGoTo = "closewindows.php"; 
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editdrivermember = "-1";
if (isset($_GET['driver_id'])) {
  $colname_editdrivermember = $_GET['driver_id'];
}
mysql_select_db($database_ml, $ml);
$query_editdrivermember = sprintf("SELECT * FROM drivermember WHERE driver_id = %s", GetSQLValueString($colname_editdrivermember, "int"));
$editdrivermember = mysql_query($query_editdrivermember, $ml) or die(mysql_error());
$row_editdrivermember = mysql_fetch_assoc($editdrivermember);
$totalRows_editdrivermember = mysql_num_rows($editdrivermember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>แก้ไขข้อมูลผู้ขับรถส่งสินค้า</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form2">
<input name="pictureorder-ori" type="hidden" id="pictureorder-ori" value="<?php echo $row_editdrivermember['driver_doc'];?>">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">แก้ไขข้อมูลผู้ขับรถส่งสินค้า</td>
    </tr>
    <tr>
      <td><table width="600" align="center">
        <tr valign="baseline">
          <td width="168" align="right" nowrap bgcolor="#FFFFCC"><span class="small">ชื่อ *:</span></td>
          <td width="235" bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_first_name" value="<?php echo $row_editdrivermember['driver_first_name']; ?>" size="32">
          </span></td>
          <td width="181" bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">นามสกุล *:</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_last_name" value="<?php echo $row_editdrivermember['driver_last_name']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขบัตรประชาชน *:</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_id_card" value="<?php echo $row_editdrivermember['driver_id_card']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">ตัวอย่าง 1234567890123</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ที่อยู่ :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_1" value="<?php echo $row_editdrivermember['address_1']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ถนน :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_2" value="<?php echo $row_editdrivermember['address_2']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ตำบล / แขวง :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_3" value="<?php echo $row_editdrivermember['address_3']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">อำเภอ / เขต :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="adress_4" value="<?php echo $row_editdrivermember['adress_4']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">จังหวัด :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="address_5" value="<?php echo $row_editdrivermember['address_5']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">รหัสไปรษณีย์ :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="postcode" value="<?php echo $row_editdrivermember['postcode']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขโทรศัพท์ติดต่อ *:</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_tel" value="<?php echo $row_editdrivermember['driver_tel']; ?>" size="32">
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
          <td bgcolor="#FFFFCC" class="small">ข้อมูลเดิม <?php echo $row_editdrivermember['driver_bookbank_name']; ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">สาขา :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_bookbank_branch" value="<?php echo $row_editdrivermember['driver_bookbank_branch']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขบัญชี :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_bookbank_id" value="<?php echo $row_editdrivermember['driver_bookbank_id']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC" class="small">ตัวอย่าง 1234567890</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขทะเบียนรถ :</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="driver_car_id" value="<?php echo $row_editdrivermember['driver_car_id']; ?>" size="32">
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
          <td bgcolor="#FFFFCC" class="small">ข้อมูลเดิม <?php echo $row_editdrivermember['driver_car_type']; ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเหตุคนขับรถ :</span></td>
          <td bgcolor="#FFFFCC">
            <span class="small">
            <textarea name="driver_comment" cols="35" rows="5" id="driver_comment"><?php echo $row_editdrivermember['driver_comment']; ?></textarea>
            </span></td>
          <td bgcolor="#FFFFCC" class="small"><span class="small">( เครื่องหมาย * จะต้องกรอกให้ครบ)</span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">เอกสารคนขับรถ :</span></td>
          <td bgcolor="#FFFFCC">
		    <span class="small">
		    <?php
//          echo $row_detel_drivermember['driver_doc'];
		  if ($row_editdrivermember['driver_doc'] <>"")
			  {
					echo '<a href="fileupload/'.$row_editdrivermember['driver_doc'].'">ดูเอกสาร</a>';
			  }
		  else
			  	{
					echo 'รอการปรับปรุงข้อมูล';
				}		  
		 ?>
            </span></td>
          <td bgcolor="#FFFFCC" class="small">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">Upload เอกสาร :</span></td>
          <td colspan="2" bgcolor="#FFFFCC"><span class="small">
            <label for="driver_car_type">
              <input name="fileupload" type="file" id="fileupload" size="25" maxlength="255">
            </label>
          </span></td>
          </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td align="center"><input name="driver_id" type="hidden" id="driver_id" value="<?php echo $row_editdrivermember['driver_id']; ?>">            <input type="submit" class="small" value="บันทึกข้อมูล"></td>
          <td class="small">&nbsp;</td>
        </tr>
      </table>
      <br>
      &nbsp;</td>
    </tr>
  </table>
  <br>
  <input type="hidden" name="MM_update" value="form2">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($editdrivermember);
?>
