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

mysql_select_db($database_ml, $ml);
$query_list_customer = "SELECT * FROM customer";
$list_customer = mysql_query($query_list_customer, $ml) or die(mysql_error());
$row_list_customer = mysql_fetch_assoc($list_customer);
$totalRows_list_customer = mysql_num_rows($list_customer);
?>
<!doctype html>
<html>

<head>

</head>

<body>
  <br>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#FFFFCC">
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" bgcolor="#FF9900" class="h3">พิมพ์ใบส่งสินค้ารวม</td>
          </tr>
          <tr>
            <td width="80%" align="center" bgcolor="#FF9900" class="h3">
              <form name="form1" method="get" action="">
                <input name="pagename" type="hidden" value="listshipment-select2">
                เลือกชื่อลูกค้า
                <select name="customer_id" id="select" class="selectpicker" data-live-search="true">
                  <?php
                  do {
                  ?>
                    <option value="<?php echo $row_list_customer['id'] ?>"><?php echo $row_list_customer['name'] ?></option>
                  <?php
                  } while ($row_list_customer = mysql_fetch_assoc($list_customer));
                  $rows = mysql_num_rows($list_customer);
                  if ($rows > 0) {
                    mysql_data_seek($list_customer, 0);
                    $row_list_customer = mysql_fetch_assoc($list_customer);
                  }
                  ?>
                </select>
                &nbsp;
                <input type="submit" name="button" id="button" value="ค้นหา">
              </form>
            </td>
          </tr>
        </table>
        <br>
</body>

</html>
<?php
mysql_free_result($list_customer);
?>