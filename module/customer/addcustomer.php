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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$filename = "cus_".date ("dmYHis");
//Upload files	
	include ("uploadfile.php");	
//เสร็จการ Upload File
	

  $insertSQL = sprintf("INSERT INTO customer (id, name, address1, address2, address3, address4, address5, postcode, telephone, faxnumber, tax_customer_id, comment_costomer, customer_doc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
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
                       GetSQLValueString($_POST['comment_customer'], "text"),
                       GetSQLValueString($newname, "text"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($insertSQL, $ml) or die(mysql_error());

  $insertGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_ml, $ml);
$query_addcustomer = "SELECT * FROM customer";
$addcustomer = mysql_query($query_addcustomer, $ml) or die(mysql_error());
$row_addcustomer = mysql_fetch_assoc($addcustomer);
$totalRows_addcustomer = mysql_num_rows($addcustomer);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>บันทึกข้อมูลลูกค้าใหม่</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">เพิ่มข้อมูลลูกค้าใหม่</td>
    </tr>
    <tr>
      <td><table width="600" align="center">
        <tr valign="baseline">
          <td width="201" align="right" nowrap><span class="small">ชื่อลูกค้า:</span></td>
          <td width="198">            <span class="small">
            <input type="text" name="name" value="" size="32">            
            </span></td>
          <td width="185"><span class="small">ชื่อบริษัท / ชื่อบุคคล</span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">ทีอยู่:</span></td>
          <td>            <span class="small">
            <input type="text" name="address1" value="" size="32">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">ถนน:</span></td>
          <td>            <span class="small">
            <input type="text" name="address2" value="" size="32">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">ตำบล / แขวง:</span></td>
          <td>            <span class="small">
            <input type="text" name="address3" value="" size="32">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">อำเภอ / เขต:</span></td>
          <td>            <span class="small">
            <input type="text" name="address4" value="" size="32">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">จังหวัด:</span></td>
          <td>            <span class="small">
            <input type="text" name="address5" value="" size="32">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">รหัสไปรษณีย์:</span></td>
          <td>            <span class="small">
            <input type="text" name="postcode" value="" size="32">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">เบอร์โทรศัพท์:</span></td>
          <td>            <span class="small">
            <input type="text" name="telephone" value="" size="32">            
            </span></td>
          <td><span class="small">ตัวอย่าง : 0812345678</span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">เบอร์โทรสาร:</span></td>
          <td>            <span class="small">
            <input type="text" name="faxnumber" value="" size="32">            
            </span></td>
          <td><span class="small">ตัวอย่าง : 036123456</span></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">หมายเลขปรจำตัวผู้เสียภาษี:</span></td>
          <td><span class="small">
            <input type="text" name="tax_customer_id" value="" size="32">
          </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap><span class="small">หมายเหตุเพิ่มเติม</span></td>
          <td><span class="small">
            <textarea name="comment_customer" cols="35" rows="5" id="comment_customer"></textarea>
          </span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap><span class="small">Upload เอกสาร</span></td>
          <td colspan="2"><span class="small">
            <input name="fileupload" type="file" id="fileupload" size="25" maxlength="255">
          </span></td>
          </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td>            <span class="small">
            <input type="submit" value="บันทึกข้อมูล">            
            </span></td>
          <td>&nbsp;</td>
        </tr>
    </table></td>
    </tr>
  </table>
  <br>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addcustomer);
?>
