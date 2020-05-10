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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_listshipment = 50;
$pageNum_listshipment = 0;
if (isset($_GET['pageNum_listshipment'])) {
  $pageNum_listshipment = $_GET['pageNum_listshipment'];
}
$startRow_listshipment = $pageNum_listshipment * $maxRows_listshipment;

$customer_id = $_GET["customer_id"];

mysql_select_db($database_ml, $ml);
//$query_listshipment = "SELECT * FROM shipment WHERE customer_id LIKE ".$customer_id." AND status = 1 ORDER BY id ASC";

$query_listshipment = "SELECT * FROM shipment WHERE customer_id LIKE ".$customer_id." AND ((status = 1 OR status = 4) and status != 9) ORDER BY id ASC";
$query_limit_listshipment = sprintf("%s LIMIT %d, %d", $query_listshipment, $startRow_listshipment, $maxRows_listshipment);
$listshipment = mysql_query($query_limit_listshipment, $ml) or die(mysql_error());
$row_listshipment = mysql_fetch_assoc($listshipment);

if (isset($_GET['totalRows_listshipment'])) {
  $totalRows_listshipment = $_GET['totalRows_listshipment'];
} else {
  $all_listshipment = mysql_query($query_listshipment);
  $totalRows_listshipment = mysql_num_rows($all_listshipment);
}
$totalPages_listshipment = ceil($totalRows_listshipment/$maxRows_listshipment)-1;
/*
$maxRows_listshipment = 25;
$pageNum_listshipment = 0;
if (isset($_GET['pageNum_listshipment'])) {
  $pageNum_listshipment = $_GET['pageNum_listshipment'];
}
$startRow_listshipment = $pageNum_listshipment * $maxRows_listshipment;

mysql_select_db($database_ml, $ml);
$query_listshipment = "SELECT * FROM shipment WHERE customer_id LIKE ".$customer_id." AND status = 1 ORDER BY id DESC";
$query_limit_listshipment = sprintf("%s LIMIT %d, %d", $query_listshipment, $startRow_listshipment, $maxRows_listshipment);
$listshipment = mysql_query($query_limit_listshipment, $ml) or die(mysql_error());
$row_listshipment = mysql_fetch_assoc($listshipment);

if (isset($_GET['totalRows_listshipment'])) {
  $totalRows_listshipment = $_GET['totalRows_listshipment'];
} else {
  $all_listshipment = mysql_query($query_listshipment);
  $totalRows_listshipment = mysql_num_rows($all_listshipment);
}
*/
//$totalPages_listshipment = ceil($totalRows_listshipment/

$queryString_listshipment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listshipment") == false && 
        stristr($param, "totalRows_listshipment") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listshipment = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listshipment = sprintf("&totalRows_listshipment=%d%s", $totalRows_listshipment, $queryString_listshipment);

$queryString_listshipment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listshipment") == false && 
        stristr($param, "totalRows_listshipment") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listshipment = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listshipment = sprintf("&totalRows_listshipment=%d %s", $totalRows_listshipment, $queryString_listshipment);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>พิมพ์ใบตั้งเบิกรวม</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<br>
<form name="form1" method="POST" action="module/pdf/printbilling-select.php" target="new">
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr></tr>
  <MM_REPEATEDREGION SOURCE="@@rs@@"><MM:DECORATION OUTLINE="Repeat" OUTLINEID=1>
    <tr></tr>
  </MM:DECORATION></MM_REPEATEDREGION>
  <tr>
    <td colspan="8" align="center" bgcolor="#FF9900" class="h3"> จัดการเอกสารใบตั้งเบิก : <span class="small"><?php echo $row_listshipment['customer_name']; ?></span>
      <input name="customer_id" type="hidden" value="<?php echo $row_listshipment['customer_id'];?>"></td>
  </tr>
  <tr>
    <td colspan="8" align="center" bgcolor="#FF9900">
    <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2" align="center" bgcolor="#66CCFF"><span class="small">กรอกข้อมูลเพิ่มเติม</span></td>
      </tr>
      <tr>
        <td width="28%" bgcolor="#FFFFCC"><span class="small">เงื่อนไขการชำระเงิน (เครดิต)</span></td>
        <td width="72%" bgcolor="#FFFFCC"><span class="small">
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
         </td>
      </tr>
      <tr>
        <td bgcolor="#FFFFCC"><span class="small">วันครบกำหนด (วัน / เดือน / ปี)</span></td>
        <td bgcolor="#FFFFCC"><span class="small">
          <input name="credit_end_date" type="text" id="credit_end_date" size="13" maxlength="13"    value="<?php echo date('d/m/Y', strtotime("tomorrow")); ?>" required>      
          </span></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFCC"><span class="small">ระบุธนาคารที่รับชำระเงิน</span></td>
        <td bgcolor="#FFFFCC"><p class="small">
          <!--<input name="billtype" type="radio" id="radio" value="1" checked="CHECKED">
          ธนาคารทหารไทย จำกัด (มหาชน) สาขาสระบุรี เลขบัญชี 3-121-1-07922-6</p> -->
          <p class="small">
            <select name="billtype" size="1" id="select">
              <option value="1" selected="selected" ><img src="images/thaibank_icon/52px/ThaiBank(7).png" width="52" height="52">&nbsp; ธนาคารทหารไทย จำกัด (มหาชน) สาขาสระบุรี กระแสรายวัน เลขบัญชี 312-1-07922-6</option>
              <option value="2"><img src="images/thaibank_icon/52px/ThaiBank(2).png" width="52" height="52">&nbsp; ธนาคารกสิกรไทย จำกัด (มหาชน) สาขาเทสโก้โลตัส สระบุรี ออมทรัพย์ เลขบัญชี 086-1-01769-9</option>
              <option value="3"><img src="images/thaibank_icon/52px/ThaiBank(14).png" width="52" height="52">&nbsp; ธนาคารกรุงศรีอยุธยา จำกัด (มหาชน) สาขาเทสโก้โลตัส สระบุรี ออมทรัพย์ เลขบัญชี 800-1-99964-4</option>
              <option value="4"><img src="images/thaibank_icon/52px/ThaiBank(2).png" width="52" height="52">&nbsp; ธนาคารกสิกรไทย จำกัด (มหาชน) (อรนุช บุตดีมี) สาขาหนองแค ออมทรัพย์ เลขบัญชี 029-8-22327-9</option>
            </select>
          </p></td>
      </tr>
      <tr>
        <td colspan="2" align="center" bgcolor="#99CCFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">&nbsp;</td>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">วันที่</td>
    <td width="15%" align="center" bgcolor="#66FFFF" class="small">เลขที่ตั๋วสินค้า</td>
    <td width="15%" align="center" bgcolor="#66FFFF" class="small">ชื่อสินค้า</td>
    <td width="15%" align="center" bgcolor="#66FFFF" class="small">ปลายทางส่งสินค้า</td>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">วันรับสินค้า<br>
      ต้นทาง</td>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">จำนวน<br>
      (ตัน)</td>
    <td width="15%" align="center" bgcolor="#66FFFF" class="small">จ่ายงานให้คนขับรถ</td>
  </tr>
  <?php 
			$count_numner = 0;			
		?>
  <?php $count_numner = $count_numner+1 ;?>
  <?php do { ?>
  <?php
	//ตรวจสอบสถานะเอกสารใบส่งรับสินค้าจากคนขับรถ
		$status_error = "";
		mysql_select_db($database_ml, $ml);
		$sql = "SELECT status , picturestatus1 , picturestatus2 , picturestatus3 , picturestatus4 FROM shipment WHERE id =".$row_listshipment['id'];
		$r1=mysql_query($sql, $ml) or die(mysql_error());			
		$row_status_error = mysql_fetch_assoc($r1);	
		$status_error_picturestatus2 = $row_status_error['picturestatus2'];		
//		$status_error =$row_status_error['picturestatus2'];
		$status_error_picturestatus1 =$row_status_error['picturestatus1'];
		$status_error_picturestatus3 =$row_status_error['picturestatus3'];
		$status_error_picturestatus4 =$row_status_error['picturestatus4'];
		$status_shipment = $row_status_error['status'];
		if($status_error_picturestatus1 == "")
		{
			$status_error = 0;
			$status_text = "รอพิมพ์ใบส่งสินค้า";
		}
		else	
		{
			if ($status_error_picturestatus2 == "")
			{
				$status_error = 0;
				$status_text = "รอเอกสารจากคนขับรถ"; 			
			}
			else
			if (($status_error_picturestatus1 <> "") and($status_error_picturestatus2 <> "") )
			{							
					$status_error = 1;
					if (($status_shipment == 4)and($status_error_picturestatus3 == "")and($status_error_picturestatus4 == ""))
						{$status_text = "รอพิมพ์ใบแจ้งหนี้";}
					if (($status_shipment == 4)and($status_error_picturestatus3 <> "")and($status_error_picturestatus4 == ""))
						{$status_text = "รอพิมพ์ใบเสร็จรับเงิน"; $status_error = 0;}
					if (($status_shipment == 1)and($status_error_picturestatus1 <> "")and($status_error_picturestatus2 <> ""))
						{$status_text = ""; $status_error = 1;}						
			}
			else
			{			
				$status_error = 0;
			}
			
		}
		
				
		//$status_text = "รอพิมพ์ใบแจ้งหนี้"
		//$status_text = "รอพิมพ์ใบเสร็จรับเงิน"
					
	?>
  <tr>
    <td width="5%" align="center" bgcolor="#FFFFFF">
    <?php
    	if ($status_error == 1)
		{
			echo "<input type='checkbox' name='id[]' id='id' value=".$row_listshipment['id'].">";
		}
		else
		{
			echo "&nbsp;";
		}	
	?>
<!--    <input type="checkbox" name="id[]" id="id" value="<?php //echo $row_listshipment['id'];?>"> -->
    </td>
    <td width="5%" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $row_listshipment['transaction_date']; ?></span></td>
    <td width="15%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['ref_product_payment_id']; ?></td>
    <td width="15%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['type_product']; ?></td>
    <td width="15%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_destination2']; ?></td>
    <td width="5%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_dateout']; ?></td>
    <td width="5%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_amount']; ?></td>
    <td width="15%" align="center" bgcolor="#FFFFFF" class="small">
	<?php
	   echo $status_text;			
	?>
    </td>
  </tr>
  <?php } while ($row_listshipment = mysql_fetch_assoc($listshipment)); ?>
  <tr>
    <td colspan="10" align="center" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="พิมพ์ใบแจ้งหนี้รวม"></td>
  </tr>
  </table>
</form>
<p><br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
</p>
  <tr>
    <td align="center" bgcolor="#FFFFCC"><br>
</body>
</html>
<?php
mysql_free_result($listshipment);
?>
