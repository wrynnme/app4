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

$maxRows_listreceipt = 25;
$pageNum_listreceipt = 0;
if (isset($_GET['pageNum_listreceipt'])) {
  $pageNum_listreceipt = $_GET['pageNum_listreceipt'];
}
$startRow_listreceipt = $pageNum_listreceipt * $maxRows_listreceipt;

mysql_select_db($database_ml, $ml);
$query_listreceipt = "SELECT * FROM shipment WHERE status = 2 ORDER BY id DESC";
$query_limit_listreceipt = sprintf("%s LIMIT %d, %d", $query_listreceipt, $startRow_listreceipt, $maxRows_listreceipt);
$listreceipt = mysql_query($query_limit_listreceipt, $ml) or die(mysql_error());
$row_listreceipt = mysql_fetch_assoc($listreceipt);

if (isset($_GET['totalRows_listreceipt'])) {
  $totalRows_listreceipt = $_GET['totalRows_listreceipt'];
} else {
  $all_listreceipt = mysql_query($query_listreceipt);
  $totalRows_listreceipt = mysql_num_rows($all_listreceipt);
}
$totalPages_listreceipt = ceil($totalRows_listreceipt/$maxRows_listreceipt)-1;

$queryString_listreceipt = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listreceipt") == false && 
        stristr($param, "totalRows_listreceipt") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listreceipt = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listreceipt = sprintf("&totalRows_listreceipt=%d%s", $totalRows_listreceipt, $queryString_listreceipt);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>จัดการใบเสร็จ</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7" align="center" bgcolor="#6699FF" class="h3">จัดการใบเสร็จรับเงิน</td>
      </tr>
      <tr>
        <td width="10%" align="center" bgcolor="#66FFFF" class="small">เลขที่เอกสาร</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">เลขที่ตั๋วสินค้า</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">ผู้ซื้อ</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">ปลายทางส่งสินค้า</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">วันที่สินค้า<br>
        ถึงปลายทางทาง</td>
        <td width="5%" align="center" bgcolor="#66FFFF" class="small">จำนวนเงิน</td>
        <td width="5%" align="center" bgcolor="#66FFFF" class="small">พิมพ์ใบเสร็จ</td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>
        
        <?php do { ?>
		<?php $count_numner = $count_numner+1 ;?>
        <tr>
            <td width="10%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listreceipt['product_payment_id']; ?></td>
          <td width="15%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listreceipt['ref_product_payment_id']; ?></td>            
          <td width="15%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listreceipt['customer_name']; ?></td>
          <td width="15%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listreceipt['customer_destination']; ?></td>
          <td width="15%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listreceipt['date3']; ?></td>
          <td width="5%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listreceipt['product_amount']; ?></td>
            <td width="5%" align="center" bgcolor="#FFFFFF" class="small">พิมพ์</td>
        </tr>
        
		<?php } while ($row_listreceipt = mysql_fetch_assoc($listreceipt)); ?>
        <tr>
          <td colspan="7" align="center" bgcolor="#FFFFFF"><table width="20%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><a href="<?php printf("%s?pageNum_listreceipt=%d%s", $currentPage, 0, $queryString_listreceipt); ?>">First</a></td>
              <td align="center"><a href="<?php printf("%s?pageNum_listreceipt=%d%s", $currentPage, max(0, $pageNum_listreceipt - 1), $queryString_listreceipt); ?>">Previous</a></td>
              <td align="center">&nbsp;</td>
              <td align="center"><a href="<?php printf("%s?pageNum_listreceipt=%d%s", $currentPage, min($totalPages_listreceipt, $pageNum_listreceipt + 1), $queryString_listreceipt); ?>">Next</a></td>
              <td align="center"><a href="<?php printf("%s?pageNum_listreceipt=%d%s", $currentPage, $totalPages_listreceipt, $queryString_listreceipt); ?>">Last</a></td>
            </tr>
          </table></td>
        </tr>
    </table>
      <br>
    </body>
</html>
<?php
mysql_free_result($listreceipt);
?>
