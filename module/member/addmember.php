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
  $insertSQL = sprintf("INSERT INTO member (username, password, firstname, lastname, telephone, status) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($insertSQL, $ml) or die(mysql_error());

  $insertGoTo = "closewindows.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
$query_addmember = "SELECT * FROM member";
$addmember = mysql_query($query_addmember, $ml) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>บันทึกข้อมูลลูกค้าใหม่</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<form method="POST" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FF6600" class="h3">เพิ่มข้อมูลเจ้าหน้าที่ใหม่</td>
    </tr>
    <tr>
      <td valign="top"><table width="600" align="center">
        <tr valign="baseline">
          <td width="201" align="right" nowrap><span class="small">ชื่อ</span></td>
          <td width="198">            <span class="small">
            <input name="firstname" type="text" id="firstname" value="" size="32">            
            </span></td>
          <td width="185" class="small">*ไม่มีคำนำหน้า</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">นามสกุล:</span></td>
          <td>            <span class="small">
            <input name="lastname" type="text" id="lastname" value="" size="32">            
            </span></td>
          <td class="small">*</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">หมายเลขบัตรประชาชน</span></td>
          <td>            <span class="small">
            <input name="username" type="text" id="username" value="" size="32">            
            </span></td>
          <td class="small">*เลข13หลัก ไม่มีเว้นวรรค</td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right"><span class="small">หมายเลขโทรศัพท์</span></td>
          <td>            <span class="small">
            <input name="telephone" type="text" id="telephone" value="" size="32">            
            </span></td>
          <td class="small">*
            <input name="status" type="hidden" id="status" value="2"></td>
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
mysql_free_result($addmember);
?>
