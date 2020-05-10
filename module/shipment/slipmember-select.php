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
<meta charset="utf-8">
<title>พิมพ์ใบแจ้งหนี้รวม</title>
<!--Script ค้นหาข้อมูลแสดงใน Listbox  -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="module/shipment/dist/css/bootstrap-select.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="module/shipment/dist/js/bootstrap-select.js"></script>
<!--END Script ค้นหาข้อมูลแสดงใน Listbox  -->

<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
</head>

<body>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" bgcolor="#66FF66" class="h3">พิมพ์สลิปค่าจ้างคนขับรถ</td>
        <td align="center" bgcolor="#66FF66" class="h3"></td>
      </tr>
      <tr>
        <td width="80%" align="center" bgcolor="#66FF66" class="h3"><form name="form1" method="get" action="">
        <input name="pagename" type="hidden" value="slipmember-select2">
          <label for="select">เลือกชื่อคนขับรถ</label>
          <select name="drivermember_id" id="select" class="selectpicker" data-live-search="true">
            <?php
do {  
?>
            <option value="<?php echo $row_list_drivermember['driver_id']?>">
			<?php echo $row_list_drivermember['driver_first_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row_list_drivermember['driver_last_name']?></option>
            <?php
} while ($row_list_drivermember = mysql_fetch_assoc($list_drivermember));
  $rows = mysql_num_rows($list_drivermember);
  if($rows > 0) {
      mysql_data_seek($list_drivermember, 0);
	  $row_list_drivermember = mysql_fetch_assoc($list_drivermember);
  }
?>
          </select>
       &nbsp; 
       <input type="submit" name="button" id="button" value="ค้นหา">
        </form></td>
        <td width="9%" align="center" bgcolor="#66FF66" class="h3"></td>
      </tr>
    </table>
      <br>
    </body>
</html>
<?php
mysql_free_result($list_drivermember);
?>
