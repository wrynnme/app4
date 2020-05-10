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

$maxRows_listbilling = 25;
$pageNum_listbilling = 0;
if (isset($_GET['pageNum_listbilling'])) {
  $pageNum_listbilling = $_GET['pageNum_listbilling'];
}
$startRow_listbilling = $pageNum_listbilling * $maxRows_listbilling;

mysql_select_db($database_ml, $ml);
$query_listbilling = "SELECT * FROM shipment WHERE status = 2 ORDER BY id DESC";
$query_limit_listbilling = sprintf("%s LIMIT %d, %d", $query_listbilling, $startRow_listbilling, $maxRows_listbilling);
$listbilling = mysql_query($query_limit_listbilling, $ml) or die(mysql_error());
$row_listbilling = mysql_fetch_assoc($listbilling);

if (isset($_GET['totalRows_listbilling'])) {
  $totalRows_listbilling = $_GET['totalRows_listbilling'];
} else {
  $all_listbilling = mysql_query($query_listbilling);
  $totalRows_listbilling = mysql_num_rows($all_listbilling);
}
$totalPages_listbilling = ceil($totalRows_listbilling/$maxRows_listbilling)-1;

$queryString_listbilling = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_listbilling") == false && 
        stristr($param, "totalRows_listbilling") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_listbilling = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_listbilling = sprintf("&totalRows_listbilling=%d%s", $totalRows_listbilling, $queryString_listbilling);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>จัดการใบตั้งเบิก</title>
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
        <td colspan="7" align="center" bgcolor="#FF6600" class="h3">จัดการเอกสารใบเสร็จรับเงิน</td>
      </tr>
      <tr>
        <td width="14%" align="center" bgcolor="#FFFF99" class="small">วันที่</td>
        <td width="18%" align="center" bgcolor="#FFFF99" class="small">เลขที่ตั๋วสินค้า</td>
        <td width="16%" align="center" bgcolor="#FFFF99" class="small">ผู้ซื้อ</td>
        <td width="16%" align="center" bgcolor="#FFFF99" class="small">ปลายทางส่งสินค้า</td>
        <td width="16%" align="center" bgcolor="#FFFF99" class="small">วันที่สินค้า<br>
        ถึงปลายทาง</td>
        <td width="13%" align="center" bgcolor="#FFFF99" class="small">จำนวน<br>
        (ตัน)</td>
        <td width="7%" align="center" bgcolor="#FFFF99" class="small">พิมพ์ใบเสร็จรับเงิน</td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>
        
        <?php do { ?>
		<?php $count_numner = $count_numner+1 ;?>
        <tr>
            <td width="14%" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $row_listbilling['transaction_date']; ?></span></td>
          <td width="18%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listbilling['ref_product_payment_id']; ?></td>            
          <td width="16%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listbilling['customer_name']; ?></td>
          <td width="16%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listbilling['customer_destination']; ?></td>
          <td width="16%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listbilling['date3']; ?></td>
          <td width="13%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listbilling['product_amount']; ?></td>
            <td width="7%" align="center" bgcolor="#FFFFFF" class="small"><a target="new" href="status2.php?id=<?php echo $row_listbilling['id']; ?>&product_payment_id=<?php echo $row_listbilling['product_payment_id']; ?>">พิมพ์</a></td>
        </tr>
         
		<?php } while ($row_listbilling = mysql_fetch_assoc($listbilling)); ?>
        <tr>
          <td colspan="7" align="center" bgcolor="#FFFFFF"><table width="20%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><a href="<?php printf("%s?pageNum_listbilling=%d%s", $currentPage, 0, $queryString_listbilling); ?>">First</a></td>
              <td align="center"><a href="<?php printf("%s?pageNum_listbilling=%d%s", $currentPage, max(0, $pageNum_listbilling - 1), $queryString_listbilling); ?>">Previous</a></td>
              <td align="center">&nbsp;</td>
              <td align="center"><a href="<?php printf("%s?pageNum_listbilling=%d%s", $currentPage, min($totalPages_listbilling, $pageNum_listbilling + 1), $queryString_listbilling); ?>">Next</a></td>
              <td align="center"><a href="<?php printf("%s?pageNum_listbilling=%d%s", $currentPage, $totalPages_listbilling, $queryString_listbilling); ?>">Last</a></td>
            </tr>
          </table></td>
        </tr>
    </table>
      <br>
    </body>
</html>
<?php
mysql_free_result($listbilling);

//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
?>
