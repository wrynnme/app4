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
$filename = "cus_".date ("dmYHis");

include "uploadfile.php";
	
	if ($newname == "")
	{
		$newname = $_POST["pictureorder-ori"];
	}

  $updateSQL = sprintf("UPDATE customer SET name=%s, address1=%s, address2=%s, address3=%s, address4=%s, address5=%s, postcode=%s, telephone=%s, faxnumber=%s, tax_customer_id=%s, comment_costomer=%s, customer_doc=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['address1'], "text"),
                       GetSQLValueString($_POST['address2'], "text"),
                       GetSQLValueString($_POST['address3'], "text"),
                       GetSQLValueString($_POST['address4'], "text"),
                       GetSQLValueString($_POST['address5'], "text"),
                       GetSQLValueString($_POST['postcode'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['faxnumber'], "text"),
                       GetSQLValueString($_POST['tax_customer_id'], "text"),
					   GetSQLValueString($_POST['comment_costomer'], "text"),
					   GetSQLValueString($newname, "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());

//  $updateGoTo = "listcustomer.php";
  $updateGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_customer = "-1";
if (isset($_GET['id'])) {
  $colname_edit_customer = $_GET['id'];
}
mysql_select_db($database_ml, $ml);
$query_edit_customer = sprintf("SELECT * FROM customer WHERE id = %s", GetSQLValueString($colname_edit_customer, "int"));
$edit_customer = mysql_query($query_edit_customer, $ml) or die(mysql_error());
$row_edit_customer = mysql_fetch_assoc($edit_customer);
$totalRows_edit_customer = mysql_num_rows($edit_customer);
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
<input name="id" type="hidden" value="<?php echo $row_edit_customer['id']; ?>">
<input name="pictureorder-ori" type="hidden" id="pictureorder-ori" value="<?php echo $row_edit_customer['customer_doc']; ?>">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">แก้ไขข้อมูลลูกค้า</td>
    </tr>
    <tr>
      <td><table width="600" align="center">
        <tr valign="baseline">
          <td width="201" align="right" nowrap bgcolor="#FFFFCC"><span class="small">ชื่อลูกค้า:</span></td>
          <td width="198" bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="name" value="<?php echo $row_edit_customer['name']; ?>" size="32">            
            </span></td>
          <td width="185" bgcolor="#FFFFCC"><span class="small">ชื่อบริษัท / ชื่อบุคคล</span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ทีอยู่:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="address1" value="<?php echo $row_edit_customer['address1']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ถนน:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="address2" value="<?php echo $row_edit_customer['address2']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">ตำบล / แขวง:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="address3" value="<?php echo $row_edit_customer['address3']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">อำเภอ / เขต:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="address4" value="<?php echo $row_edit_customer['address4']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">จังหวัด:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="address5" value="<?php echo $row_edit_customer['address5']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">รหัสไปรษณีย์:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="postcode" value="<?php echo $row_edit_customer['postcode']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">เบอร์โทรศัพท์:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="telephone" value="<?php echo $row_edit_customer['telephone']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC"><span class="small">ตัวอย่าง : 0812345678</span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">เบอร์โทรสาร:</span></td>
          <td bgcolor="#FFFFCC">            <span class="small">
            <input type="text" name="faxnumber" value="<?php echo $row_edit_customer['faxnumber']; ?>" size="32">            
            </span></td>
          <td bgcolor="#FFFFCC"><span class="small">ตัวอย่าง : 036123456</span></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเลขปรจำตัวผู้เสียภาษี:</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input type="text" name="tax_customer_id" value="<?php echo $row_edit_customer['tax_customer_id']; ?>" size="32">
          </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">หมายเหตุเพิ่มเติม</span></td>
          <td bgcolor="#FFFFCC"><textarea name="comment_costomer" cols="35" rows="5" id="comment_costomer"><?php echo $row_edit_customer['comment_costomer']; ?></textarea></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">เอกสารประกอบของลูกค้า</span></td>
          <td bgcolor="#FFFFCC">
		  <?php 
		  //แสดงข้อมูลเอกสาร Upload ถ้ามีมีจะขึ้นข้อความว่า "รอการอัพโหลดเอกสาร" ถ้ามีข้อมูล จะแสดง Link ดูเอกสาร
		 	if ($row_edit_customer['customer_doc']<>"")
				{
					echo '<a href="fileupload/'.$row_edit_customer['customer_doc'].'" target="new">ดูเอกสาร</a>';
				}
			else
				{
					echo 'รอการอัพโหลดเอกสาร';
				}		 
//		  echo $row_edit_customer['customer_doc'];
		  //##################################################################################
		  ?></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap bgcolor="#FFFFCC"><span class="small">Upload&nbsp;เอกสาร</span></td>
          <td bgcolor="#FFFFCC"><span class="small">
            <input name="fileupload" type="file" id="fileupload" size="25" maxlength="255">
          </span></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><input name="id" type="hidden" id="id" value="<?php echo $row_edit_customer['id']; ?>"></td>
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
mysql_free_result($edit_customer);
?>
