<?php require_once("../../Connections/ml.php"); ?>
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
/*
	$colname_delete_shipment = "-1";
	if (isset($_GET['id'])) {
	  $colname_delete_shipment = $_GET['id'];
	}
	mysql_select_db($database_ml, $ml);
	$query_delete_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_delete_shipment, "int"));
	$delete_shipment = mysql_query($query_delete_shipment, $ml) or die(mysql_error());
	$row_delete_shipment = mysql_fetch_assoc($delete_shipment);
	$totalRows_delete_shipment = mysql_num_rows($delete_shipment);
	
	if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
	
	if ($row_delete_shipment['status']==1)
	{
		$new_status = 2;
		$picturestatus3 = $_GET['product_payment_id']."-3.pdf";
	}
	else
	{
		$new_status = $row_delete_shipment['status'];
		$picturestatus3 = $_GET['product_payment_id']."-3.pdf";
	}


//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE shipment SET picturestatus3,status WHERE id=%s",
                       GetSQLValueString($picturestatus3, "text"),
					   GetSQLValueString($new_status, "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());

  $updateGoTo = "123.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


	
  $deleteSQL = sprintf("UPDATE shipment SET picturestatus3=%s ,status=%s WHERE id=%s",
					   GetSQLValueString($picturestatus3, "text"),
                       GetSQLValueString($new_status, "int"),
					   GetSQLValueString($_GET['id'], "int"));
					   

  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($deleteSQL, $ml) or die(mysql_error());

  //$deleteGoTo = "../../index.php?pagename=listshipment";
  $deleteGoTo = "../pdf/printbilling.php?id=".$_GET['id'];
  
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
*/

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
</head>

<body>
<?php $id_shipment = $_GET['id']; ?>
<?php
//ตรวจสอบสถานะเอกสารใบส่งรับสินค้าจากคนขับรถ
	$status_error = "";
	mysql_select_db($database_ml, $ml);
	$sql = "SELECT 	picturestatus2 FROM shipment WHERE id =".$id_shipment;
	$r1=mysql_query($sql, $ml) or die(mysql_error());			
	$row_status_error = mysql_fetch_assoc($r1);			
	$status_error =$row_status_error['picturestatus2'];
	if ($row_status_error['picturestatus2'] == "")
	{
		$updateGoTo = "errorbill.php";
		header(sprintf("Location: %s", $updateGoTo));
	}
	else
	{
?>
<form action="../pdf/printbilling.php" name="form1" method="GET">
<input name="id" type="hidden" value="<?php echo $id_shipment ;?>">

  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center" bgcolor="#66CCFF"><span class="small">กรอกข้อมูลเพิ่มเติม</span></td>
    </tr>
    <tr>
      <td width="28%" bgcolor="#FFCCFF"><span class="small">เงื่อนไขการชำระเงิน (เครดิต)</span></td>
      <td width="72%" bgcolor="#FFCCFF"><span class="small">
      
	<script language="javascript">
		function checkzero()
		{
			var d = new Date(); // วันนี้
			var textbox = document.getElementById('credit');
			var end_date = document.getElementById('credit_end_date');
			var credit;
			var text_date_end;
			//ข้างบน เอา ID มาใช้ในการอ้างครับ 
			if( parseInt( '0'+textbox.value )<=0) {    
				alert('จำนวนวันที่ให้เครดิตขั้นต่ำ 0 วันค่ะ');
				textbox.value=1;
				extbox.focus();
			}
			else
			{
//				credit = d.setDate(d.getDate() + parseInt(textbox.value));
//				text_date_end = new Date(credit).toISOString("en-US").slice(0, 10).replace('T', ' ');
//				end_date.value =  text_date_end.replace(/-/g, '/');


				credit = d.setDate(d.getDate() + parseInt(textbox.value));
//				text_date_end = new Date(credit).toISOString("en-US").slice(0, 10).replace('T', ' ');
//				end_date.value =  text_date_end.replace(/-/g, '/');

//var timestamp = 1439329773; // replace your timestamp
				var date = new Date(credit);
				var formattedDate = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
				end_date.value = formattedDate
			}
		}
	</script>
        <input name="credit" type="number" id="credit" size="3" maxlength="3" value="1" onchange="checkzero()" required> 
        วัน</span>
        <?php
/*		echo "<br>";
        echo "   วันนี้วันที่  ".date("Y/m/d");
		$date_start = strtotime(date("Y/m/d"));
		echo "    date_start = ". $date_start;
		$date_stop = $date_start + (60 *60 *24);		
		echo "    date_stop = ". $date_stop;		
		echo "     พรุ่งนี้คือวันที่ : ".date("Y/m/d",$date_stop);  
*/
		?>
        </td>
    </tr>
    <tr>
      <td bgcolor="#FFCCFF"><span class="small">วันครบกำหนด (วัน / เดือน / ปี)</span></td>
      <td bgcolor="#FFCCFF">
		         <input name="credit_end_date" type="text" id="credit_end_date" size="13" maxlength="13"    value="<?php echo date('d/m/Y', strtotime("tomorrow")); ?>" required>      
      <!--<span class="small">
        <input name="credit_end_d" type="text" id="credit_end_d"  placeholder="วว" size="5" maxlength="2"> 
        / 
        <input name="credit_end_m" type="text" id="credit_end_m" placeholder="ดด" size="5" maxlength="2"> 
        / 
        <input name="credit_end_y" type="text" id="credit_end_y" placeholder="ปปปป" size="6" maxlength="4">
      </span> -->
      </td>
    </tr>
    <tr>
      <td rowspan="4" bgcolor="#99FF00"><span class="small">ระบุธนาคารที่รับชำระเงิน</span></td>
      <td bgcolor="#FFFF99"><span class="small">
        <input name="billtype" type="radio" id="radio" value="1" checked="CHECKED" >
        <img src="images/thaibank_icon/52px/ThaiBank(7).png" width="52" height="52">&nbsp; ธนาคารทหารไทย จำกัด (มหาชน) สาขาสระบุรี กระแสรายวัน เลขบัญชี 312-1-07922-6</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFF66"><span class="small"><strong>
        <input name="billtype" type="radio" id="radio2" value="2">
      <img src="images/thaibank_icon/52px/ThaiBank(2).png" width="52" height="52">&nbsp; </strong>ธนาคารกสิกรไทย จำกัด (มหาชน) สาขาเทสโก้โลตัส สระบุรี ออมทรัพย์ เลขบัญชี 086-1-01769-9</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFF99"><span class="small"> 
        <input name="billtype" type="radio" id="radio3" value="3">
       <strong><img src="images/thaibank_icon/52px/ThaiBank(14).png" width="52" height="52">&nbsp; </strong>ธนาคารกรุงศรีอยุธยา จำกัด (มหาชน) สาขาเทสโก้โลตัส สระบุรี ออมทรัพย์ เลขบัญชี 800-1-99964-4</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFF66"><span class="small"> 
        <input name="billtype" type="radio" id="radio4" value="4">
      <strong> <img src="images/thaibank_icon/52px/ThaiBank(2).png" width="52" height="52">&nbsp; </strong>ธนาคารกสิกรไทย จำกัด (มหาชน) (อรนุช บุตดีมี) สาขาหนองแค ออมทรัพย์ เลขบัญชี 029-8-22327-9</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#99CCFF"><span class="small">
        <input type="submit" name="button" id="button" value="ทำงานต่อ">
      </span></td>
    </tr>
  </table>  
</form>
<?php 
	}
//จบตรวจสอบสถานะเอกสารใบส่งรับสินค้าจากคนขับรถ
?>
</body>
</html>
<?php
//mysql_free_result($delete_shipment);
?>
