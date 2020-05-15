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
$query_list_drivermember = "SELECT * FROM drivermember";
$list_drivermember = mysql_query($query_list_drivermember, $ml) or die(mysql_error());
$row_list_drivermember = mysql_fetch_assoc($list_drivermember);
$totalRows_list_drivermember = mysql_num_rows($list_drivermember);
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
            <td align="center" bgcolor="#66FF66" class="h3">พิมพ์สลิปค่าจ้างคนขับรถ</td>
            <td align="center" bgcolor="#66FF66" class="h3"></td>
          </tr>
          <tr>
            <td width="80%" align="center" bgcolor="#66FF66" class="h3">
              <form name="form1" method="get" action="">
                <input name="pagename" type="hidden" value="slipmember-select2">
                <label for="select">เลือกชื่อคนขับรถ</label>
                <select name="drivermember_id" id="select" class="selectpicker" data-live-search="true">
                  <?php
                  do {
                  ?>
                    <option value="<?php echo $row_list_drivermember['driver_id'] ?>">
                      <?php echo $row_list_drivermember['driver_first_name'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row_list_drivermember['driver_last_name'] ?></option>
                  <?php
                  } while ($row_list_drivermember = mysql_fetch_assoc($list_drivermember));
                  $rows = mysql_num_rows($list_drivermember);
                  if ($rows > 0) {
                    mysql_data_seek($list_drivermember, 0);
                    $row_list_drivermember = mysql_fetch_assoc($list_drivermember);
                  }
                  ?>
                </select>
                &nbsp;
                <input type="submit" name="button" id="button" value="ค้นหา">
              </form>
            </td>
            <td width="9%" align="center" bgcolor="#66FF66" class="h3"></td>
          </tr>
        </table>
        <br>
</body>

</html>
<?php
mysql_free_result($list_drivermember);
?>