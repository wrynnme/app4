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


//เรียกฐานข้อมูลลูกค้าเพื่อใช้ในการสร้าง Listbox ค้นหาชื่อลูกค้า
mysql_select_db($database_ml, $ml);
$query_list_customer = "SELECT * FROM customer";
$list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
$row_list_customer = mysql_fetch_assoc($list_customer);
$totalRows_list_customer = mysql_num_rows($list_customer);
//สิ้นสุดเรียกฐานข้อมูลลูกค้าเพื่อใช้ในการสร้าง Listbox ค้นหาชื่อลูกค้า

//เรียกฐานข้อมูลหมายเลขใบส่งสินค้าเพื่อใช้ในการสร้าง Listbox ค้นหาใบส่งสินค้า
mysql_select_db($database_ml, $ml);
$query_show_product_payment_id = "SELECT * FROM shipment";
$show_product_payment_id = mysql_query($query_show_product_payment_id, $ml) or die(mysql_error());
$row_show_product_payment_id = mysql_fetch_assoc($show_product_payment_id);
$totalRows_show_product_payment_id = mysql_num_rows($show_product_payment_id);
//สิ้นสุดเรียกฐานข้อมูลหมายเลขใบส่งสินค้าเพื่อใช้ในการสร้าง Listbox ค้นหาใบส่งสินค้า




$maxRows_list_product_payment_id = 1;
$pageNum_list_product_payment_id = 0;
if (isset($_GET['pageNum_list_product_payment_id'])) {
  $pageNum_list_product_payment_id = $_GET['pageNum_list_product_payment_id'];
}
$startRow_list_product_payment_id = $pageNum_list_product_payment_id * $maxRows_list_product_payment_id;

mysql_select_db($database_ml, $ml);
$query_list_product_payment_id = "SELECT product_payment_id FROM shipment";
$query_limit_list_product_payment_id = sprintf("%s LIMIT %d, %d", $query_list_product_payment_id, $startRow_list_product_payment_id, $maxRows_list_product_payment_id);
$list_product_payment_id = mysql_query($query_limit_list_product_payment_id, $ml) or die(mysql_error());
$row_list_product_payment_id = mysql_fetch_assoc($list_product_payment_id);

if (isset($_GET['totalRows_list_product_payment_id'])) {
  $totalRows_list_product_payment_id = $_GET['totalRows_list_product_payment_id'];
} else {
  $all_list_product_payment_id = mysql_query($query_list_product_payment_id);
  $totalRows_list_product_payment_id = mysql_num_rows($all_list_product_payment_id);
}
$totalPages_list_product_payment_id = ceil($totalRows_list_product_payment_id / $maxRows_list_product_payment_id) - 1;



//
if (!isset($_GET["status"])) {
  $status = 999;
} else {
  $status = $_GET["status"];
}
//echo $status;

if (!isset($_GET["list_product_payment_id"])) {
  $product_payment_id = $_GET["product_payment_id"];
} else {
  $product_payment_id = $_GET["product_payment_id"];
}

if (!isset($_GET["customer_id"])) {
  $customer_id = $_GET["customer_id"];
} else {
  $customer_id = $_GET["customer_id"];
}



mysql_select_db($database_ml, $ml);
switch ($status) {
  case 0:
    $query_listshipment = "SELECT * FROM shipment WHERE status = 0 ORDER BY id DESC";
    break;
  case 1:
    $query_listshipment = "SELECT * FROM shipment WHERE status = 1 ORDER BY id DESC";
    break;
  case 2:
    $query_listshipment = "SELECT * FROM shipment WHERE status = 2 ORDER BY id DESC";
    break;
  case 3:
    $query_listshipment = "SELECT * FROM shipment WHERE status = 3 ORDER BY id DESC";
    break;
  case 4:
    $query_listshipment = "SELECT * FROM shipment WHERE status = 4 ORDER BY id DESC";
    break;
  case 9:
    $query_listshipment = "SELECT * FROM shipment WHERE status = 9 ORDER BY id DESC";
    break;
  case 99:
    $query_listshipment = "SELECT * FROM shipment WHERE car_id LIKE '-' ORDER BY id DESC";
    break;
  case 100:
    $query_listshipment = "SELECT * FROM shipment WHERE transaction_date LIKE '" . date("Y-m-d") . "' ORDER BY id DESC";
    break;
    //case 99 : $query_listshipment = "SELECT * FROM shipment WHERE status = 99 ORDER BY id DESC";break;
  case 999:
    $query_listshipment = "SELECT * FROM shipment ORDER BY id DESC";
    break;
  case 8888:
    $query_listshipment = "SELECT * FROM shipment WHERE customer_id LIKE " . $customer_id . " ORDER BY id DESC";
    break;
  case 9999:
    $query_listshipment = "SELECT * FROM shipment WHERE product_payment_id LIKE '" . $product_payment_id . "'";
    break;
}
//echo $query_listshipment;
//$query_listshipment = "SELECT * FROM shipment ORDER BY id DESC";
$query_limit_listshipment = sprintf("%s LIMIT %d, %d", $query_listshipment, $startRow_listshipment, $maxRows_listshipment);
$listshipment = mysql_query($query_limit_listshipment, $ml) or die(mysql_error());
$row_listshipment = mysql_fetch_assoc($listshipment);



if (isset($_GET['totalRows_listshipment'])) {
  $totalRows_listshipment = $_GET['totalRows_listshipment'];
} else {
  $all_listshipment = mysql_query($query_listshipment);
  $totalRows_listshipment = mysql_num_rows($all_listshipment);
}
$totalPages_listshipment = ceil($totalRows_listshipment / $maxRows_listshipment) - 1;

$queryString_listshipment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_listshipment") == false &&
      stristr($param, "totalRows_listshipment") == false
    ) {
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

  <script type="text/javascript">
    function MM_openBrWindow(theURL, winName, features) { //v2.0
      window.open(theURL, winName, features);
    }

    function MM_jumpMenu(targ, selObj, restore) { //v3.0
      eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
      if (restore) selObj.selectedIndex = 0;
    }
  </script>

  <!--Script ค้นหาข้อมูลแสดงใน Listbox  -->
  <!--END Script ค้นหาข้อมูลแสดงใน Listbox  -->

</head>

<body>
  <br>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FFFFCC">
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="6" align="center" bgcolor="#FFCCFF" class="h3">แสดงรายการเอกสาร</td>
            <td colspan="2" align="center" bgcolor="#FFCCFF" class="h3">
              <form name="form1" method="post" action="">
                <select name="status" class="small" id="status" onChange="MM_jumpMenu('parent',this,0)">
                  <option value="#">เลือกสถานะเอกสาร</option>
                  <option value="index.php?pagename=0&status=999">ทั้งหมด</option>
                  <option value="index.php?pagename=0&status=0">รอพิมพ์ใบส่งสินค้า</option>
                  <option value="index.php?pagename=0&status=1">รอพิมพ์ใบตั้งเบิก</option>
                  <option value="index.php?pagename=0&status=2">รอพิมพ์ใบเสร็จรับเงิน</option>
                  <option value="index.php?pagename=0&status=3">รอพิมพ์สลิปค่าจ้าง</option>
                  <option value="index.php?pagename=0&status=4">สิ้นสุดกระบวนการ</option>
                  <option value="index.php?pagename=0&status=9">เอกสารถูกยกเลิก</option>
                  <!--<option value="index.php?pagename=0&status=99">รายการมาใหม่ล่าสุด</option> -->
                </select>
              </form>
            </td>
            <td width="10%" align="center" bgcolor="#FFCCFF" class="h3">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" rowspan="2" align="center" bgcolor="#66FFFF" class="small">วันที่</td>
            <td width="15%" align="center" bgcolor="#66FFFF" class="small">เลขที่ใบส่งสินค้า</td>
            <td width="10%" rowspan="2" align="center" bgcolor="#66FFFF" class="small">เลขที่ตั๋วสินค้า</td>
            <td width="20%" align="center" bgcolor="#66FFFF" class="small">ผู้ซื้อ</td>
            <td width="15%" rowspan="2" align="center" bgcolor="#66FFFF" class="small">ปลายทางส่งสินค้า</td>
            <td width="10%" rowspan="2" align="center" bgcolor="#66FFFF" class="small">วันรับสินค้า<br>
              ต้นทาง</td>
            <td width="5%" rowspan="2" align="center" bgcolor="#66FFFF" class="small">จำนวน<br>
              (ตัน)</td>
            <td width="10%" rowspan="2" align="center" bgcolor="#66FFFF" class="small">สถานะ</td>
            <td rowspan="2" align="center" valign="middle" bgcolor="#66FFFF"></td>
          </tr>
          <tr>
            <td width="15%" align="center" bgcolor="#66FFFF" class="small">
              <!--//เรียกข้อมูลหมายเลขใบส่งสินค้าเพื่อใช้ในการสร้าง Listbox ค้นหารายการสินค้า -->
              <span class="h5">หมายเลขใบส่งสินค้า : </span>
              <select name="product_payment_id" id="product_payment_id" class="selectpicker" data-live-search="true" onChange="MM_jumpMenu('parent',this,0)">
                <option value="index.php?pagename=0&status=9999"><?php echo กรอกหมายเลขใบส่งสินค้า; ?></option>
                <?php
                do {
                ?>
                  <option value="<?php echo "index.php?pagename=0&status=9999&product_payment_id=" . $row_show_product_payment_id['product_payment_id'] ?>">
                    <?php echo $row_show_product_payment_id['product_payment_id'] ?>
                  </option>
                <?php
                } while ($row_show_product_payment_id = mysql_fetch_assoc($show_product_payment_id));
                $rows = mysql_num_rows($show_product_payment_id);
                if ($rows > 0) {
                  mysql_data_seek($show_product_payment_id, 0);
                  $row_show_product_payment_id = mysql_fetch_assoc($show_product_payment_id);
                }
                ?>
              </select>
              <!--//สิ้นสุดเรียกข้อมูลหมายเลขใบส่งสินค้าเพื่อใช้ในการสร้าง Listbox ค้นหารายการสินค้า -->
            </td>
            <td align="center" bgcolor="#66FFFF" class="small">
              <!--//เรียกข้อมูลลูกค้าเพื่อใช้ในการสร้าง Listbox ค้นหารายการสินค้า -->
              <span class="h5">หมายเลขใบส่งสินค้า : </span>
              <select name="customer_id" id="customer_id" class="selectpicker" data-live-search="true" onChange="MM_jumpMenu('parent',this,0)">
                <option value="index.php?pagename=0&status=8888"><?php echo พิมพ์ชื่อลูกค้า; ?></option>
                <?php
                do {
                ?>
                  <option value="<?php echo "index.php?pagename=0&status=8888&customer_id=" . $row_list_customer['id'] ?>">
                    <?php echo $row_list_customer['name'] ?>
                  </option>
                <?php
                } while ($row_list_customer = mysql_fetch_assoc($list_customer));
                $rows = mysql_num_rows($list_customer);
                if ($rows > 0) {
                  mysql_data_seek($list_customer, 0);
                  $row_list_customer = mysql_fetch_assoc($list_customer);
                }
                ?>
              </select>
              <!--//สิ้นสุดเรียกข้อมูลลูกค้าเพื่อใช้ในการสร้าง Listbox ค้นหารายการสินค้า -->
            </td>
          </tr>
          <?php
          $count_numner = 0;
          ?>

          <?php do { ?>
            <?php $count_numner = $count_numner + 1; ?>
            <tr>
              <td width="10%" align="center" bgcolor="#FFFFFF"><span class="small"><?php echo $row_listshipment['transaction_date']; ?></span></td>

              <?php
              //เช็คเอกสารใบแจ้งหนี้ที่่ต้องพิมพ์หลังจากพิมพ์ใบสลิปให้คนขับรถแล้วและสถานะเอกสารเป็นสิ้นสุดแล้ว
              if ((($row_listshipment['picturestatus3'] == "") and ($row_listshipment['picturestatus4'] == "")) and ($row_listshipment['status'] == "4")) {
                echo "<td width=15% align=center bgcolor=666666><span class=small>" . $row_listshipment['product_payment_id'] . "</span></td>";
              } else {
                if ((($row_listshipment['picturestatus3'] <> "") and ($row_listshipment['picturestatus4'] == "")) and ($row_listshipment['status'] == "4")) {
                  echo "<td width=15% align=center bgcolor=CCCCCC><span class=small>" . $row_listshipment['product_payment_id'] . "</span></td>";
                } else {
                  if ((($row_listshipment['picturestatus3'] == "") and ($row_listshipment['picturestatus4'] <> "")) and ($row_listshipment['status'] == "4")) {
                    echo "<td width=15% align=center bgcolor=999999><span class=small>" . $row_listshipment['product_payment_id'] . "</span></td>";
                  } else {
                    if ((($row_listshipment['picturestatus3'] <> "") or ($row_listshipment['picturestatus4'] <> "")) and ($row_listshipment['status'] == "4")) {
                      echo "<td width=15% align=center bgcolor=#FFFFFF><span class=small>" . $row_listshipment['product_payment_id'] . "</span></td>";
                    } else {
                      echo "<td width=15% align=center bgcolor=#FFFFFF><span class=small>" . $row_listshipment['product_payment_id'] . "</span></td>";
                    }
                  }
                }
              }
              ?>
              <td width="10%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['ref_product_payment_id']; ?></td>
              <td width="20%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_name']; ?></td>
              <td width="15%" align="left" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['customer_destination2']; ?></td>
              <td width="10%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_dateout']; ?></td>
              <td width="5%" align="center" bgcolor="#FFFFFF" class="small"><?php echo $row_listshipment['product_amount']; ?></td>
              <?php
              //echo $row_listshipment['status'];
              switch ($row_listshipment['status']) {
                  //case "99" : $status_txt = "รอพิมพ์ใบส่งสินค้า"; $bg = "#FFFFFF" ; break;						
                case "0":
                  $status_txt = "รอพิมพ์ใบส่งสินค้า";
                  $bg = "#FFFFFF";
                  break;
                case "1":
                  $status_txt = "รอพิมพ์ใบตั้งเบิก";
                  $bg = "#FFFF00";
                  break;
                case "2":
                  $status_txt = "รอพิมพ์ใบเสร็จรับเงิน";
                  $bg = "#33CCFF";
                  break;
                case "3":
                  $status_txt = "รอพิมพ์ใบสลิปค่าจ้าง";
                  $bg = "#FF9900";
                  break;
                case "4":
                  if ($row_listshipment['rate_pricein_type2'] = 2) {
                    $status_txt = "สิ้นสุดงานแล้ว";
                    $bg = "#00FF00";
                    break;
                  } else {
                    $status_txt = "รอบันทึกข้อมูลการเบิกเงิน";
                    $bg = "#FF00FF";
                    break;
                  }
                case "9":
                  $status_txt = "เอกสารถูกยกเลิก";
                  $bg = "#FF0000";
                  break;
              }

              ?>
              <td width="10%" bgcolor=" <?php echo $bg; ?>" align="center" class="small">
                <?php
                echo $status_txt;
                //echo $row_listshipment['status'];
                //switch ($row_listshipment['status']){
                //case "0" : echo "รอพิมพ์ใบส่งสินค้า"; break;
                //case "1" : echo "รอพิมพ์ใบตั้งเบิก"; break;
                //case "2" : echo "รอพิมพ์ใบเสร็จรับเงิน"; break;
                //case "3" : echo "รอพิมพ์ใบสลิปค่าจ้าง"; break;
                //case "4" : echo "สิ้นสุดงานแล้ว"; break;																			
                //}

                ?>
              </td>
              <td align="center" bgcolor="#FFFFFF">
                <a href="module/shipment/detelcustomer.php?id=<?php echo $row_listshipment['id']; ?>" target="thewiondows">
                  <ion-icon name="paper"></ion-icon>
                </a>
              </td>
            </tr>

          <?php } while ($row_listshipment = mysql_fetch_assoc($listshipment)); ?>
          <tr>
            <td colspan="9" align="center" bgcolor="#FFFFFF">
              <table width="50%" border="0" cellspacing="0" cellpadding="0">
                <!--<tr>
              <td align="center"><a href="<? php // printf("%s?pageNum_listshipment=%d%s", $currentPage, 0, $queryString_listshipment); 
                                          ?>">First</a></td>
              <td align="center"><a href="<? php // printf("%s?pageNum_listshipment=%d%s", $currentPage, max(0, $pageNum_listshipment - 1), $queryString_listshipment); 
                                          ?>">Previous</a></td>
              <td align="center">&nbsp;</td>
              <td align="center"><a href="<? php // printf("%s?pageNum_listshipment=%d%s", $currentPage, min($totalPages_listshipment, $pageNum_listshipment + 1), $queryString_listshipment); 
                                          ?>">Next</a></td>
              <td align="center"><a href="<? php // printf("%s?pageNum_listshipment=%d%s", $currentPage, $totalPages_listshipment, $queryString_listshipment); 
                                          ?>">Last</a></td>
            </tr> -->
                <tr>
                  <td align="center">หน้าที่
                    <?php
                    for ($dw_i = 0; $dw_i <= $totalPages_listshipment; $dw_i++) {
                      switch ($status) {
                        case 999:
                          echo "<a href=?status=999&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          break;
                        case 0:
                          echo "<a href=?status=0&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          break;
                        case 1:
                          echo "<a href=?status=1&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          break;
                        case 2:
                          echo "<a href=?status=2&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          break;
                        case 3:
                          echo "<a href=?status=3&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          break;
                        case 4:
                          echo "<a href=?status=4&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          break;
                        case 9:
                          echo "<a href=?status=9&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          break;
                        case 8888:
                          echo "<a href=?status=8888&customer_id=" . $customer_id . "&pageNum_listshipment=" . $dw_i . ">" . $dw_i . "</a>  ";
                          //						default : echo "<a href=?pageNum_listshipment=".$dw_i.">".$dw_i."</a>  "; break;										
                      }
                    }

                    ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="9" align="center" bgcolor="#FFFFFF" class="small">
              <table width="80%" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="10%" align="center" bgcolor="#FFFFCC">หมายเหตุ </td>
                  <td width="15%" align="center">1. รอพิมพ์ใบส่งสินค้า</td>
                  <td width="15%" align="center" bgcolor="#FFFF00">2. รอพิมพ์ใบตั้งเบิก</td>
                  <td width="15%" align="center" bgcolor="#33CCFF">3. รอพิมพ์ใบเสร็จรับเงิน</td>
                  <td width="15%" align="center" bgcolor="#FF9900">4. รอพิมพ์ใบสลิปค่าจ้าง</td>
                  <td width="15%" align="center" bgcolor="#00FF00">5. สิ้นสุดกระบวนการ</td>
                  <td width="15%" align="center" bgcolor="#FF0000">9. เอกสารถูกยกเลิก</td>
                </tr>
                <tr>
                  <td colspan="2" align="center" bgcolor="#FFFFCC">สีช่องเลขที่ใบส่งสินค้ากรณีสถานะสิ้นสุดกระบวนการ</td>
                  <td align="center" bgcolor="#666666">ยังไม่พิมพ์ใบแจ้งหนี้ / ใบเสร็จ</td>
                  <td align="center" bgcolor="#CCCCCC">ยังไม่พิมพ์ใบเสร็จ</td>
                  <td align="center" bgcolor="#999999">ยังไม่พิมพ์ใบแจ้งหนี้</td>
                  <td align="center" bgcolor="#FFFFFF">ปกติ</td>
                  <td align="center" bgcolor="#FFFFCC">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
</body>

</html>
<?php
mysql_free_result($list_product_payment_id);

mysql_free_result($listshipment);

//  onclick= "return confirm('ต้องการลบข้อมูล ออกจากระบบจริงหรือไม่')"
?>