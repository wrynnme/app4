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

$maxRows_listshipment = 25;
$pageNum_listshipment = 0;
if (isset($_GET['pageNum_listshipment'])) {
  $pageNum_listshipment = $_GET['pageNum_listshipment'];
}
$startRow_listshipment = $pageNum_listshipment * $maxRows_listshipment;

mysql_select_db($database_ml, $ml);
$query_listshipment = "SELECT * FROM shipment";
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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>จัดการใบส่งสินค้า</title>
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7" align="center" bgcolor="#FF9900" class="h3">จัดการเอกสารใบจ่ายสินค้า</td>
        <td colspan="3" align="center" bgcolor="#FF9900" class="h3"><span class="h5"><a href="index.php?pagename=listshipment">Reload</a></span></td>
      </tr>
      <tr>
        <td width="10%" align="center" bgcolor="#66FFFF" class="small">วันที่</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">เลขที่ใบจ่ายสินค้า</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">ผู้ซื้อ</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">ปลายทางส่งสินค้า</td>
        <td width="15%" align="center" bgcolor="#66FFFF" class="small">วันรับสินค้า<br>
        ต้นทาง</td>
        <td width="5%" align="center" bgcolor="#66FFFF" class="small">จำนวน<br>
        (ตัน)</td>
        <td width="5%" align="center" bgcolor="#66FFFF" class="small">สถานะ</td>
        <td colspan="3" align="center" valign="middle" bgcolor="#FFCC66"><a href="module/shipment/addshipment.php" target="thelogis" class="btn btn-primary"><ion-icon name="add-circle-outline"></ion-icon> 
          <span class="h6"><span class="btn-block">เพิ่ม</span></span></a></td>
        </tr>
        <?php 
			$count_numner = 0;			
		?>
        
        <?php do { ?>
		<?php $count_numner = $count_numner+1 ;?>
        <tr>
            <td width="15" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $row_listshipment['transaction_date']; ?></span></td>
          <td width="15" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_payment_id']; ?></td>            
          <td width="15" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_name']; ?></td>
          <td width="15" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_destination']; ?></td>
          <td width="15" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_dateout']; ?></td>
          <td width="15" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_amount']; ?></td>
            <td width="15" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['status']; ?></td>
            <td width="3%" align="center" bgcolor="#FFFFFF"><a href="module/shipment/detelcustomer.php?id=<?php echo $row_listshipment['id']; ?>" target="thewiondows"><ion-icon name="paper"></ion-icon></a>            
            </td>
             
            <td width="3%" align="center" bgcolor="#FFFFFF"><a href="module/shipment/editshipment.php?id=<?php echo $row_listshipment['id']; ?>" target="thewiondows"><ion-icon name="settings"></ion-icon></td>
                        
            <td width="3%" align="center" bgcolor="#FFFFFF"><a href="module/shipment/deleteshipment.php?id=<?php echo $row_listshipment['id']; ?>" class="btn-outline-danger" onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"><ion-icon name="remove-circle-outline"></ion-icon></a></td>            
      </tr>
        
		<?php } while ($row_listshipment = mysql_fetch_assoc($listshipment)); ?>
        <tr>
          <td colspan="10" align="center" bgcolor="#FFFFFF"><table width="20%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><a href="<?php printf("%s?pageNum_listshipment=%d%s", $currentPage, 0, $queryString_listshipment); ?>">First</a></td>
              <td align="center"><a href="<?php printf("%s?pageNum_listshipment=%d%s", $currentPage, max(0, $pageNum_listshipment - 1), $queryString_listshipment); ?>">Previous</a></td>
              <td align="center">&nbsp;</td>
              <td align="center"><a href="<?php printf("%s?pageNum_listshipment=%d%s", $currentPage, min($totalPages_listshipment, $pageNum_listshipment + 1), $queryString_listshipment); ?>">Next</a></td>
              <td align="center"><a href="<?php printf("%s?pageNum_listshipment=%d%s", $currentPage, $totalPages_listshipment, $queryString_listshipment); ?>">Last</a></td>
            </tr>
          </table></td>
        </tr>
    </table>
      <br>
    </body>
</html>
<?php
mysql_free_result($listshipment);

//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
?>
