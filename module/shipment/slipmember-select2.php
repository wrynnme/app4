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

$drivermember_id = $_GET["drivermember_id"];

mysql_select_db($database_ml, $ml);
$query_listshipment = "SELECT * FROM shipment WHERE drivermember_id LIKE ".$drivermember_id." AND 	status_oil = 1 ORDER BY id ASC";
$listshipment = mysql_query($query_listshipment, $ml) or die(mysql_error());
$row_listshipment = mysql_fetch_assoc($listshipment);
$totalRows_listshipment = mysql_num_rows($listshipment);

mysql_select_db($database_ml, $ml);
$query_listdrivermember = "SELECT * FROM drivermember WHERE driver_id =".$drivermember_id;
$listdrivermember = mysql_query($query_listdrivermember, $ml) or die(mysql_error());
$row_listdrivermember = mysql_fetch_assoc($listdrivermember);
$totalRows_listdrivermember = mysql_num_rows($listdrivermember);

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
<title>พิมพ์สลิปค่าจ้างคนขับรถ</title>
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
<form name="form1" method="post" action="module/pdf/printslipmember-select.php" target="new">
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <MM_REPEATEDREGION SOURCE="@@rs@@"><MM:DECORATION OUTLINE="Repeat" OUTLINEID=1>
    <tr></tr></MM:DECORATION></MM_REPEATEDREGION> 
  <tr>
    <td colspan="9" align="center" bgcolor="#FF9900" class="h3"><span class="small">พิมพ์ใบสลิปคนขับรถ :<?php echo $row_listdrivermember['driver_first_name']; ?>&nbsp;&nbsp;<?php echo $row_listdrivermember['driver_last_name']; ?> </span>
      <input name="drivermember_id" type="hidden" value="<?php echo $row_listshipment['drivermember_id'];?>"></td>
  </tr>
  <tr>
    <td colspan="9" align="center" bgcolor="#FF9900" class="small">ค่าดำเนินการ 
      <select name="payout_bill_type" id="payout_bill_type">
        <option value="10" selected="selected">10</option>
        <option value="12">12</option>
      </select> %</td>
  </tr>
  <tr>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">&nbsp;</td>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">วันที่</td>
    <td width="15%" align="center" bgcolor="#66FFFF" class="small">หมายเลขใบส่งสินค้า</td>
    <td width="15%" align="center" bgcolor="#66FFFF" class="small">ปลายทางส่งสินค้า</td>
    <td width="15%" align="center" bgcolor="#66FFFF" class="small">วันรับสินค้า</td>
    <td width="10%" align="center" bgcolor="#66FFFF" class="small">ค่าจ้่าง</td>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">ค่าจ้างเพิ่มเติม</td>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">ค่าน้ำมัน</td>
    <td width="5%" align="center" bgcolor="#66FFFF" class="small">จ่ายงานให้คนขับรถ</td>
  </tr>
  <?php 
			$count_numner = 0;			
		?>
  <?php $count_numner = $count_numner+1 ;?>

  <?php
  	if ($totalRows_listshipment != 0)
	{
		do {
		//ค้นหาข้อมูลการเบิกน้ำมันในแต่ละบิลส่งของ
		mysql_select_db($database_ml, $ml);
		$query_shopment = "SELECT product_payment_id FROM shipment WHERE id = ".$row_listshipment['id'];
		$list_query_shipment = mysql_query($query_shopment, $ml) or die(mysql_error());
		$row_query_shipment = mysql_fetch_assoc($list_query_shipment);
		$search_shipment = $row_query_shipment['product_payment_id'];
		
		$query_receipt_member = "SELECT payout_oil_bill_total FROM receipt_member WHERE product_payment_id LIKE '".$search_shipment."'";
		$list_query_receipt_member = mysql_query($query_receipt_member, $ml) or die(mysql_error());
		$row_query_receipt_member = mysql_fetch_assoc($list_query_receipt_member);
		$show_payout_oil_bill_total = $row_query_receipt_member['payout_oil_bill_total'];
			
		echo "
		  <tr>
			<td width=5% align=center bgcolor=#FFFFFF>
				<input type=checkbox name=id[] id=id value=".$row_listshipment['id'].">  				  	
			</td>
			<td width=5% align=center bgcolor=#FFFFFF><span class=small>".$row_listshipment['transaction_date']."</span></td>
			<td width=15% align=left bgcolor=#FFFFFF class=small>".$row_listshipment['product_payment_id']."</td>
			<td width=15% align=left bgcolor=#FFFFFF class=small>".$row_listshipment['customer_destination2']."</td>
			<td width=15% align=left bgcolor=#FFFFFF class=small>".$row_listshipment['product_dateout']."</td>
			<td width=10% align=center bgcolor=#FFFFFF class=small>".$row_listshipment['rate_priceout_type1']."</td>
			<td width=5% align=center bgcolor=#FFFFFF class=small>".$row_listshipment['rate_priceout_type3']."</td>
			<td width=5% align=center bgcolor=#FFFFFF class=small>".$show_payout_oil_bill_total."</td>
			<td width=5% align=center bgcolor=#FFFFFF class=small>";			
					if ($row_listshipment['drivermember_id'] == 0)
						{					
							echo '<img src="module/shipment/images/wrong.png" width="50" height="50">';
						}
					else
						{
							echo '<img src="module/shipment/images/car.jpg" width="50" height="50">';
						}
			echo "</td>
		</tr>";
		} while ($row_listshipment = mysql_fetch_assoc($listshipment));
		echo "<tr>
			<td colspan=10 align=center bgcolor=#FFFFFF><input type=submit name=button id=button value=พิมพ์ใบสลิปค่าจ้าง></td>
		  </tr>";	
	}
	else
	{
	echo "
		  <tr>
			<td colspan=8 align=center bgcolor=#FFFFFF>
				ไม่พบข้อมูลการส่งสินค้า <a href=index.php?pagename=slipmember-select>กลับ</a>    	
			</td>
		  </tr>";	
	}
  
  
  
  
  ?>
  
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

mysql_free_result($listdrivermember);
?>
